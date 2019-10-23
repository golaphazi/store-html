<?php
Class operation{
	private $txt_array = [];
	private $txt_sort = [];
	
	private $status = false;
	
	
	private $ele_array = [];
	
	private $ek_array = [];
	
	private static $instance;
	
	public function __construct( $load = true){
		if( $load ){
			$this->elementor_array();
			$this->ekit_array();
			$this->text_to_array();
			//echo '<pre>'; print_r($this->txt_array); echo '</pre>';
		}
	}
	public function elementor_array(){
		$get_content = file_get_contents( 'mirgate/elementor.json' );
		$encode = json_decode($get_content, true);
		foreach($encode as $k=>$v){
			$this->ele_array[$k] = ['value' => $v['value'], 'library' => $v['library']];
		}
	}
	public function ekit_array(){
		$get_content = file_get_contents( 'mirgate/ekit.json' );
		$encode = json_decode($get_content, true);
		foreach($encode['icons'] as $v){
			$this->ek_array['icon icon-'.$v] = ['value' => 'icon icon-'.$v, 'library' => 'ekiticons'];
		}
	}
	public function text_to_array(){
		$txt_files 	= file_get_contents('formatted-new-icons-control-list.txt');
		$txt_exp 	= explode("\n", $txt_files);
		foreach($txt_exp as $v):
			if( strlen($v) > 2):
				$explode = explode(',', $v); 
				//$this->txt_array[] = $explode;
				$this->txt_array[$explode[1]] = [trim($explode[2]), trim($explode[3]), trim($explode[4])];
				$this->txt_sort[] = $explode[0];
			endif;
		endforeach;
	}
	
	public function data( $dir ){
		$structure = glob(rtrim($dir, "/").'/*');
		if (is_array($structure)) {
			foreach($structure as $file) {
				if (is_dir($file)) $this->data($file);
				elseif (is_file($file)){
					$this->status = false;
					$ext = explode('.', $file);
					if( strtolower(end($ext)) == 'txt'){
						$this->_files_link = $file;
						$get_content = file_get_contents($file);
						$encode = json_decode($get_content, false);
						$encode->content = $this->search_el($encode->content);
						if( $this->status ){
							file_put_contents($file, json_encode($encode) );
						}
					}
				}
					
			}
		}
	}
	
	public function search_el($data){
		if(!is_array($data)) return;
        $dta = [];
        foreach($data as $k => $v){ 
            if(is_array($v->elements) && !empty($v->elements)){
                $this->search_el($v->elements);
            }else{
                if( isset($v->widgetType) ):
					if($v->elType == 'widget' && in_array( $v->widgetType, $this->txt_sort )){
						if( isset($v->settings) ){
							
							foreach( $v->settings as $kk=>$vv):
								if( in_array($kk, array_keys($this->txt_array) ) ){
									$value = $v->settings->$kk;
									if(is_array($value) && !empty($value) ){
										$value = isset($value['value']) ? $value['value'] : 
											isset($value->value) ? $value->value : $this->__array_split($value);
											//echo '<pre>'; print_r($value); echo '</pre>';
									}
									
									$new = trim($this->txt_array[$kk][2]);
									$new = !empty($new) ? $new : $kk;
									if( !is_array($value) ){										
										if( in_array($value, array_keys($this->ele_array) ) ){
											$v->settings->$new = $this->ele_array[$value];
										}else if( in_array($value, array_keys($this->ek_array) ) ){
											$v->settings->$new = $this->ek_array[$value];
										}else if( strpos($value, 'fa fa-') !== false ){
											$icon = str_replace('fa fa-', 'fas fa-', $value);
											$v->settings->$new = ['value' => $icon, 'library' => 'fa-solid'];
										}else if( !is_array($value) ){								
											$v->settings->$new = ['value' => $value, 'library' => $this->txt_array[$kk][1]];										
										}
										unset($v->settings->$kk);
									}else{
										$v->settings->$new = $value;
									}
									
									$this->status = true;
								}
							endforeach;
						}
					}
				endif;
            }
			$dta[$k]= $v;
        }
		return $dta;
	}
	
	public function __array_split( $val ){
		if(!is_array($val)) return;
		$dat = [];
		foreach( $val as $v){
			if(is_object($v)){
				$vl = [];
				foreach($v as $k=>$value){
					$new = isset($this->txt_array[$k][2]) ? $this->txt_array[$k][2] : '';
					$new = !empty($new) ? $new : $k;						
					if( !is_object($value) ){						
						if( in_array($value, array_keys($this->ele_array) ) ){
							$value = $this->ele_array[$value];
							unset($v->$k);	
						}else if( in_array($value, array_keys($this->ek_array) ) ){
							$value = $this->ek_array[$value];
							unset($v->$k);
						}else if( strpos($value, 'fa fa-') !== false ){
							$icon = str_replace('fa fa-', 'fas fa-', $value);
							$value = ['value' => $icon, 'library' => 'fa-solid'];
							unset($v->$k);
						}						
					}
					$vl[$new] = $value;
				}
			}
			$dat[] = $vl;
		}
		
		return $dat;
	}
}
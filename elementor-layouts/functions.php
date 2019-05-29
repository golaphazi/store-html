<?php
class Data_Processor{
	
	public $dir_data;
	public $dir_name;
	public $dir_parent;
	public $working_dir;

	public function get_list($dir){
		$this->dir_parent = DIR_PATH. DIRECTORY_SEPARATOR .'layout_data' ;
		$this->dir_name = $dir;
		
		$this->working_dir = $this->dir_parent. DIRECTORY_SEPARATOR . $this->dir_name;
		$this->dir_data = $this->get_dir_data();
		return [
			'templates' => $this->templates_data(),
			'categories' => $this->categories_data()
		];
	}

	public function get_data($id){
		$id_decode = self::hash_id($id, 'decode');
		return DIR_PATH. DIRECTORY_SEPARATOR .'layout_data'. DIRECTORY_SEPARATOR . $id_decode. DIRECTORY_SEPARATOR . 'data.json';
	}		
	public function templates_data(){
		$output = [];
		foreach($this->dir_data as $key=>$value){
			
			foreach($value as $data){
				$output[] = [
					'template_id' => self::hash_id($this->dir_name. DIRECTORY_SEPARATOR . $key . DIRECTORY_SEPARATOR . $data), //md5 has of last 3 lvl directory names
					'title' => self::format($data), // 3rd level directory
					'categories' => [ // 2nd level directory
						0 => $key
					],
					'keywords' => [ // static
					   
					],
					'source' => 'elementskit-api', // static
					'hasPageSettings' => '', // static
					'thumbnail' => DIR_URL.'/layout_data/'.$this->dir_name.'/'.$key.'/'.$data.'/preview.jpg', // preview.jpg
					'preview' => DIR_URL.'/layout_data/'.$this->dir_name.'/'.$key.'/'.$data.'/preview.jpg', // preview.jpg
					'type' => 'elementskit_page', // $tab value
					'author' => 'XpeedStudio', //static
					'modified' => '2019-01-15 15:32:17' //static
				];
			}
		}
		
		return $output;
	}

	public function categories_data(){
		
		$output[] = [
				'slug' => '', //static
				'title' => 'All', //  static
			  ];

		foreach($this->dir_data as $key=>$value){
			
			foreach($value as $data){
				$output[] = [
					'slug' => $data, //static
					'title' => self::format($data), //  static
				  ];
			}
		}
		
		return $output;
	}
		
	public function get_dir_data(){
			 if(!file_exists($this->working_dir)){
					return false;
				}

			$iterator = new RecursiveIteratorIterator(
						new RecursiveDirectoryIterator($this->working_dir), 
					RecursiveIteratorIterator::SELF_FIRST);
			$results = [];	
			
			foreach($iterator as $file) {
				if($file->isDir()) {
					
					$getPath = trim( str_replace( $this->working_dir, '', $file->getRealpath() ) , DIRECTORY_SEPARATOR);

					if($this->dir_parent != $getPath){
						$exp_path = explode(DIRECTORY_SEPARATOR, $getPath);
						
						if(sizeof($exp_path) > 0){
							
							if(isset($exp_path[0]) && !empty($exp_path[0])){
								$key = $exp_path[0];
								$value = isset($exp_path[1]) ? $exp_path[1] : '';
								if(array_key_exists($key, $results)){
									if(!empty($value)){
										$results[$key][] = $value;
									}
								}else{
									if(!empty($value)){
										$results[$key] = [$value];
									}
								}
							}
						}
					}
				}
			}
			return $results;
		}
		
	public static function format($str){
		return ucwords(str_replace(['__', '_'], ' ', $str));
	}
	
	public static function hash_id($data, $type = 'encode'){
		$output = '';
		switch($type){
			case 'encode':
				$output = base64_encode($data);
			break;
			
			case 'decode':
				$output = base64_decode($data);
			break;
		}
		return $output;
	}
}

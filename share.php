<?php

Class Share{
	
	public function social_counter_url(){
		//https://gist.github.com/jonathanmoore/2640302
		//https://gist.github.com/ihorvorotnov/9132596
		
		$link = [];
		//$link['facebook'] = [ 'url' => 'https://api.facebook.com/method/links.getStats?urls=[%url%]', 'params' => [] ];
		$link['facebook'] = [ 'url' => 'http://graph.facebook.com/?ids=[%url%]', 'params' => [] ];
		$link['twitter'] = [ 'url' => 'http://urls.api.twitter.com/1/urls/count.json?url=[%url%]', 'params' => [] ];
		//$link['twitter'] = [ 'url' => 'http://cdn.api.twitter.com/1/urls/count.json?url=[%url%]', 'params' => [] ];
		$link['reddit'] = [ 'url' => 'http://buttons.reddit.com/button_info.json?url=[%url%]', 'params' => [] ];
		$link['linkedIn'] = [ 'url' => 'http://www.linkedin.com/countserv/count/share?url=[%url%]', 'params' => [] ];
		$link['delicious'] = [ 'url' => 'http://feeds.delicious.com/v2/json/urlinfo/data?url=[%url%]', 'params' => [] ];
		$link['stumbleupon'] = [ 'url' => 'http://www.stumbleupon.com/services/1.01/badge.getinfo?url=[%url%]', 'params' => [] ];
		$link['pinterest'] = [ 'url' => 'http://widgets.pinterest.com/v1/urls/count.json?source=[%source%]&url=[%url%]', 'params' => [ 'source' => 6] ];
		$link['vkontakte '] = [ 'url' => 'http://vk.com/share.php?act=[%act%]&url=[%url%]', 'params' => [ 'act' => 'count'] ];
		$link['ok '] = [ 'url' => 'https://connect.ok.ru/dk?st.cmd=[%extLike%]&tp=json&ref=[%url%]', 'params' => [ 'st.cmd' => 'extLike'] ];
		$link['yandex '] = [ 'url' => 'http://share.yandex.ru/gpp.xml?url=[%url%]', 'params' => [ 'st.cmd' => 'extLike'] ];
	}
	

	public function social_share_link(){
		$link = [];
		$link['link'] = [ ];
		$link['facebook'] = [ 'url' => 'http://www.facebook.com/sharer.php', 'params' => [ 'u' => '[%url%]', 't' => '[%title%]', 'v' => 3] ];
		$link['twitter'] = [ 'url' => 'https://twitter.com/intent/tweet', 'params' => [ 'text' => '[%title%] [%url%]', 'original_referer' => '[%url%]', 'related' => '[%author%]'] ];
		$link['linkedin'] = [ 'url' => 'https://www.linkedin.com/shareArticle', 'params' => [ 'url' => '[%url%]', 'title' => '[%title%]', 'summary' => '[%details%]'], 'source' => '[%source%]', 'mini' => true] ];
		$link['pinterest'] = [ 'url' => 'https://pinterest.com/pin/create/button/', 'params' => [ 'url' => '[%url%]', 'media' => '[%media%]', 'description' => '[%details%]'] ];
		$link['diaspora'] = [ 'url' => 'https://joindiaspora.com/bookmarklet', 'params' => [ 'url' => '[%url%]', 'title' => '[%title%]', 'v' => 1];
		$link['douban'] = [ 'url' => 'https://www.douban.com/share/service', 'params' => [ 'url' => '[%url%]', 'href' => '[%url%]', 'name' => '[%title%]', 'image' => '[%media%]' , 'title' => '[%title%]'];
		$link['draugiem'] = [ 'url' => 'https://www.draugiem.lv/say/ext/add.php', 'params' => [ 'link' => '[%url%]', 'title' => '[%title%]'];
		$link['facebook_messenger'] = [ 'url' => 'https://www.facebook.com/dialog/send', 'params' => [ 'link' => '[%url%]', 'redirect_uri' => '[%url%]', 'display' => 'popup', 'app_id' => '[%app_id%]' ];
		$link['google_classroom'] = [ 'url' => 'https://classroom.google.com/u/0/share', 'params' => [ 'url' => '[%url%]' ];
		$link['kik'] = [ 'url' => 'https://www.kik.com/send/article/', 'params' => [ 'url' => '[%url%]', 'text' => '[%details%]', 'title' => '[%title%]' ];
		$link['papaly'] = [ 'url' => 'https://papaly.com/api/share.html', 'params' => [ 'url' => '[%url%]', 'title' => '[%title%]' ];
		$link['refind'] = [ 'url' => 'https://refind.com/', 'params' => [ 'url' => '[%url%]'];
		$link['skype'] = [ 'url' => 'https://web.skype.com/share', 'params' => [ 'url' => '[%url%]'];
		$link['SMS'] = [ 'url' => 'sms://', 'params' => [ 'body' => '[%title%] [%url%]'];
		$link['trello'] = [ 'url' => 'https://trello.com/add-card', 'params' => [ 'url' => '[%url%]', 'name' => '[%title%]', 'desc' => '[%details%]', 'mode' => 'popup'];
		$link['viber'] = [ 'url' => 'viber://forward', 'params' => [ 'text' => '[%title%] [%url%]'];
		$link['threema'] = [ 'url' => 'threema://compose', 'params' => [ 'text' => '[%title%] [%url%]'];
		$link['telegram'] = [ 'url' => 'https://telegram.me/share/url', 'params' => [ 'url' => '[%url%]', 'text' => '[%title%]'];
		$link['email'] = [ 'url' => 'mailto:', 'params' => [ 'body' => 'Title: [%title%] \n\n URL: [%url%]', 'subject' => '[%title%]'];
		$link['reddit'] = [ 'url' => 'http://reddit.com/submit', 'params' => [ 'url' => '[%url%]', 'title' => '[%title%]'];
		$link['float_it'] = [ 'url' => 'http://www.designfloat.com/submit.php', 'params' => [ 'url' => '[%url%]', 'title' => '[%title%]'];
		$link['google_mail'] = [ 'url' => 'https://mail.google.com/mail/', 'params' => [ 'body' => 'Title: [%title%] \n\n URL: [%url%]', 'su' => '[%title%]', 'ui' => 2, 'view' => 'cm', 'fs' => 1, 'tf' => 1];
		$link['google_bookmarks'] = [ 'url' => 'http://www.google.com/bookmarks/mark', 'params' => [ 'bkmk' => '[%url%]', 'title' => '[%title%]', 'op' => 'edit'];
		$link['digg'] = [ 'url' => 'http://digg.com/submit', 'params' => [ 'url' => '[%url%]', 'title' => '[%title%]', 'phase' => 2];
		
	}	
	
}

New Share();
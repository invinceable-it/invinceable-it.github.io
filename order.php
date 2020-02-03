<?php

$API = [

  'key' => '1388',    //подставлять свои значения

  'secret' => '877444413af37104fcb96546a406cea0'  //подставлять свои значения

];

 
function send_the_order($post, $API) {

  $params = [

         'flow_url' => 'https://leadrock.com/URL-2453E-47162',  //ссылка на поток, подставлять свои значения

      'user_phone' => $post['phone'],

      'user_name' => $post['name'],

      'other' => $post['other'],

      'ip' => $_SERVER['REMOTE_ADDR'],

      'ua' => $_SERVER['HTTP_USER_AGENT'],

      'api_key' => $API['key'],

      'sub1' => $post['sub1'],
	  

      'sub2' => 'xen-avenue',

      'sub3' => $post['sub3'],

      'sub4' => $post['sub4'],

      'sub5' => $post['sub5'],

  ];


  $url = 'https://leadrock.com/api/v2/lead/save';

 

  $trackUrl = $params['flow_url'] . (strpos($params['flow_url'], '?') === false ? '?' : '') . '&ajax=1' . '&ip=' . $params['ip'] . '&ua=' . $params['ua'];

  foreach ($params as $param => $value) {

      if (strpos($param, 'sub') === 0) {

          $trackUrl .= '&' . $param . '=' . $value;

          unset($params[$param]);

      }

  }

  $ch = curl_init();

  curl_setopt($ch, CURLOPT_URL, $trackUrl);

  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

  curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);

  $params['track_id'] = curl_exec($ch);

 

  $params['sign'] = sha1(http_build_query($params) . $API['secret']);

 

  $ch = curl_init();

  curl_setopt($ch, CURLOPT_URL, $url);

  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

  curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);

  curl_setopt($ch, CURLOPT_POST, 1);

  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));

  curl_exec($ch);

  curl_close($ch);

 

  header('Location: ' . $post['success_page']);

}

 

if (!empty($_POST['phone'])) {

  send_the_order($_POST, $API);

}

?>

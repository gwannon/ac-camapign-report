<?php 
define('AC_API_DOMAIN', 'https://xxxxxxx.api-us1.com'); 
define('AC_API_TOKEN', 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx');
define('AC_API_LIMIT', 50);
ini_set("display_errors", 1);

?><html>
<head>
  <title>INFO CAMPAÑAS</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
  <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400;500;700&display=swap" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
</head>
<body>
  <section>
    <div class="container">
      <div class="row">
        <div class="col-12">
          <table class="table">
            <thead>
              <tr>
                <th scope="col">Nombre</th>
                <th scope="col">Título</th>
                <th scope="col">Enviados</th>
                <th scope="col">Aperturas únicas</th>
                <th scope="col">Aperturas</th>
                <th scope="col">Clicks únicos</th>
                <th scope="col">Clicks totales</th>
                <th scope="col">Bajas</th>
              </tr>
            </thead>
            <tbody>
		<?php
                 $result = getAllCampaigns();
                 foreach ($result as $campaign) { 
		    $message = getMessage($campaign->links->campaignMessage); ?>
			<tr>
			  <td><?php echo $campaign->name; ?></td>
			  <td><?php echo $message->subject; ?></td>
			  <td><?php echo $campaign->send_amt; ?></td>
			  <td><?php echo $campaign->uniqueopens; ?></td>
			  <td><?php echo $campaign->opens; ?></td>
			  <td><?php echo $campaign->uniquelinkclicks; ?></td>
			  <td><?php echo $campaign->linkclicks; ?></td>
			  <td><?php echo $campaign->unsubscribes; ?></td>
			</tr>
		<?php } ?>
	    </tbody>
	  </table>
	</div>      
      </div>
    </div>
  </section>
</body>
</html>
<?php

function getAllCampaigns() {
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, AC_API_DOMAIN."/api/3/campaigns?orders[sdate]=DESC&limit=".AC_API_LIMIT);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_HTTPHEADER, array('Api-Token: '.AC_API_TOKEN));
	$result = json_decode(curl_exec($curl));
	return $result->campaigns;
}

function getMessage($link) {
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $link);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_HTTPHEADER, array('Api-Token: '.AC_API_TOKEN));
	$result = json_decode(curl_exec($curl));
	return $result->campaignMessage;
}

?>

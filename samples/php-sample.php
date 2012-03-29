<!DOCTYPE html>
<html>
<head>
	<title>Using PHP with the DPLA</title>
</head>
<body>
	<h1>Using PHP with the DPLA</h1>
	<div>
    	<?php
    	    // Our DPLA API URL.
    	    // Search the keyword field for the term 'biscuit', facet on the subject field
    	    $url = 'http://api.dp.la/dev/item/?search_type=keyword&query=biscuit&facet=subject';

            // Use cURL to GET data from the API
    	    $ch = curl_init($url);            
            curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec ( $ch ); 
            curl_close($ch);
            
            // Decode the JSON string into something we easily use
            $json_output = json_decode($response);

            // Dump some markup for title, creator, and subject
            if (!empty($json_output->docs)) {
                echo "<h2>Items:</h2>";
                echo "<div style='margin-left: 12px; background-color: #EEE; padding: 5px;'>";
     
                foreach ( $json_output->docs as $doc ) {
                    echo "<h3>{$doc->title}</h3>";
                
                    if (!empty($doc->creator)) {
                        echo "<div style='padding-left: 12px'>";
                        echo "<h4>Creators:</h4>";
                        foreach ($doc->creator as $creator) {
                                echo "<p style='padding-left: 12px'>$creator</p>";
                        }
                        echo "</div>";
                    }
                    
                    if (!empty($doc->subhject)) {
                        echo "<div style='padding-left: 12px'>";
                        echo "<h4>Subjects:</h4>";
                        foreach ($doc->subject as $subject) {
                            echo "<p style='padding-left: 12px'>with subject of $subject</p>";
                        }
                    }
                    
                }
                echo "</div>";
            }

            // Dump some markup for facets
            if (!empty($json_output->facets)) {
                echo "<h2>Facets:</h2>";
                echo "<div style='margin-left: 12px; background-color: #EEE; padding: 5px;'>";
                
                // This will give us the facets array
                foreach ( $json_output->facets as $facet ) {
                    // This will give us the facet field and the values
                    foreach ($facet as $key => $value ) {
                        echo "<p style='padding-left: 12px'>$key has $value</p>";
                    }
                }
                echo "</div>";
            }
        ?>
	</div>
</body>
</html>
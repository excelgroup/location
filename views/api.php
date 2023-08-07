<?php
// Dolibarr API endpoint URL
$apiUrl = 'http://dolibarr/api/index.php';

// Replace 'your_api_key' with the actual API key for authentication
$apiKey = '10a1959dc5e2c9ed4247bbc339596271de65d1ae';


function CallAPI($method, $apikey, $url, $data = false)
{
    $curl = curl_init();
    $httpheader = ['DOLAPIKEY: '.$apikey];

    switch ($method)
    {
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);
            $httpheader[] = "Content-Type:application/json";

            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));

            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
            $httpheader[] = "Content-Type:application/json";

            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));

            break;
        case "DELETE":
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
            break;
        default:
            if ($data)
                $url = sprintf("%s?%s", $url, http_build_query($data));
    }

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $httpheader);

    $result = curl_exec($curl);

    curl_close($curl);
    var_dump($url);
    return $result;
}
//----------------------------------------------------Insert--------------------------------------------
/* Insert a new product
$newProductData = array(
    "ref" => "test12",
    "label" => "1",
    "price" => 100.00,
    "tax_rate" => 20,
    // Add other fields as required for your product data
);

// Make the API request to insert the product
$insertProductResult = CallAPI("POST", $apiKey, $apiUrl . "/products", $newProductData);
$insertProductResult = json_decode($insertProductResult, true);

if (isset($insertProductResult["error"]) && $insertProductResult["error"]["code"] >= "300") {
    // Handle the API error here (e.g., display an error message)
    echo "Error occurred while inserting the product using Dolibarr API.";
} else {
    // Product inserted successfully
    echo "New product inserted with ID: " . $insertProductResult["result"]["id"];
}
*/


//----------------------------------------------------Select--------------------------------------------
/*
$listProduits = [];
$produitParam = [
    "limit" => 10,
    "sortfield" => "rowid",
    "sortorder"=>"DESC",
    "fields" => "id,ref,label,price", // Replace with the fields you want
];

$listProduitsResult = CallAPI("GET", $apiKey, $apiUrl . "/products", $produitParam);
$listProduitsResult = json_decode($listProduitsResult, true);

if (is_array($listProduitsResult) && !isset($listProduitsResult["error"])) {
    foreach ($listProduitsResult as $produit) {
        // Access the specific fields you retrieved from the API response
        $productData = array(
            "id" => intval($produit["id"]),
            "ref" => html_entity_decode($produit["ref"], ENT_QUOTES),
            "label" => html_entity_decode($produit["label"], ENT_QUOTES),
            "price" => floatval($produit["price"]),
        );

        $listProduits[] = $productData;
    }
} else {
    // Handle the API error here (e.g., display an error message)
    echo "Error occurred while retrieving product list from Dolibarr API.";
}
var_dump($listProduits);
*/

//----------------------------------------------------Update--------------------------------------------
/*
// Data to be updated
$data = array(
    'rowid' => 1861, 
    'label' => 'union services bureau', 
    'price' => 50.99, 
);






// Call the CallAPI function to perform the update request
// Make the API request to update the product
$response =  CallAPI("PUT", $apiKey, $apiUrl . "/products/".$data['rowid'], $data);

// Process the response
if ($response !== false) {
    // $response contains the API response data, which can be in JSON, XML, or other formats
    // You can parse and use the data according to your needs.
    // For example, if the response is in JSON format, you can use json_decode($response, true) to convert it to an array.
    $data = json_decode($response, true);
    
} else {
    // Error handling in case the API request fails
    echo "API request failed!";
}
*/
//----------------------------------------------------Delete--------------------------------------------
/*
// Data to be updated
$data = array(
    'rowid' => 1859, 
    'label' => 'union services bureau', 
    'price' => 50.99, 
);






// Call the CallAPI function to perform the update request
// Make the API request to update the product
$response =  CallAPI("DELETE", $apiKey, $apiUrl . "/products/".$data['rowid'], $data);

// Process the response
if ($response !== false) {
    // $response contains the API response data, which can be in JSON, XML, or other formats
    // You can parse and use the data according to your needs.
    // For example, if the response is in JSON format, you can use json_decode($response, true) to convert it to an array.
    $data = json_decode($response, true);
    
} else {
    // Error handling in case the API request fails
    echo "API request failed!";
}
*/

?>
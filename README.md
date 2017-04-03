# Maropost-API-Wrapper
A JSON PHP wrapper for the Maropost API.

BY USING THIS SOFTWARE YOU AGREE THAT THE USE OF THE SOFTWARE IS AT YOUR OWN RISK.

#How to use:
-	include_once( "maropost.php" );
- $m = new \Maropost\maropost();
- $APIType = $m->subAPIType();

- E.G Add new products:
`$m = new \Maropost\maropost();
$products = $m->products();
$array = array(
'id' => 4,
'product' => array( 'item_id' => '390', 'description' => 'Brown Horse' )
);
$products->post_new_product($array);`

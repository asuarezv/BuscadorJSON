<?php
$data = file_get_contents("data-1.json");
$inmuebles = json_decode($data);
$filtroAply = (isset($_POST["fAply"]) && boolval($_POST["fAply"]));
if (isset($_POST["fCiudad"]))    {$filtroCiudad =    $_POST["fCiudad"];}
if (isset($_POST["fTipo"]))      {$filtroTipo =      $_POST["fTipo"];}
if (isset($_POST["fPrecioIni"])) {$filtroPrecioIni = $_POST["fPrecioIni"];}
if (isset($_POST["fPrecioFin"])) {$filtroPrecioFin = $_POST["fPrecioFin"];}
$matchCiudad = true;
$matchTipo = true;
$matchPrecio = true;
try {
  foreach($inmuebles as $key => $json) {
    $precio = str_ireplace(["$",","], "", $json->Precio);
    $precio = intval($precio);
    $matchPrecio = ($precio >= intval($filtroPrecioIni) && $precio <= intval($filtroPrecioFin));

    if($filtroAply){
      if ($filtroCiudad=="" || boolval($json->Ciudad == $filtroCiudad)) {
        $matchCiudad = true;
      } else {
        $matchCiudad = false;
      }

      if ($filtroTipo=="" || boolval($json->Tipo == $filtroTipo)) {
        $matchTipo = true;
      } else {
        $matchTipo = false;
      }

    }

    if($filtroAply && !($matchCiudad && $matchTipo && $matchPrecio)){
      continue;
    }
?>
 <div class="row">
   <div class="col m12">
      <div class="card horizontal itemMostrado">
        <img src="img/home.jpg">
        <div class="card-stacked">
          <div class="card-content">
            <?php
              foreach($json as $keyProp => $prop){
                $class = ($keyProp=="Precio") ? 'class="precioTexto"' : null;
                if($keyProp=="Id"){ continue; }
                echo "<p><strong>$keyProp:</strong> <span $class>$prop</span><p>";
              }
             ?>
          </div>
          <div class="card-action">
            <a href="#" class="precioTexto">VER MÁS</a>
          </div>
        </div>
      </div>
    </div>
 </div>
<?php
  }
}catch (Exception $e) {
  echo $e->getMessage();
}
?>

<?php header('Content-Type: text/html; charset=iso-8859-15'); ?>
<!DOCTYPE html >
  <head>
  <meta charset="iso-8859-15"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Sorte Verde</title>
        <!-- Favicon-->
        <link rel="sortcut icon" type="image/gif" href="assets/img/icon.png" />
        <!-- Font Awesome icons (free version)-->
        <script src="https://use.fontawesome.com/releases/v5.15.1/js/all.js" crossorigin="anonymous"></script>
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
    <style>
      #map {
    width: 100%;
		height: 500px; 
      }
    </style>
  </head>

  <body id="page-top">
  <?php include_once "navegacao.php" ?>
        <!-- Portfolio Section-->
        <section class="page-section portfolio" id="portfolio">
            <div class="container">
                <!-- Portfolio Section Heading-->
                <br>
                <br>
                <br>
                <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">PONTOS DE COLETA</h2>
                <!-- Icon Divider-->
                <div class="divider-custom">
                    <div class="divider-custom-line"></div>
                    <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                    <div class="divider-custom-line"></div>
                </div>
            </div>
        </section>
    <div>
        <!-- About Section-->
        <section class="page-section bg-primary text-white mb-0" id="about">
            <div class="container">
                <!-- About Section Content-->
                <form class="user">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Escolha o tipo de descarte:</label>
                              <select id="idmarkers" name="idmarkers" onchange="initMap(this)">
                                <option value=""></option>
                                  <?php
                                      
                                      include_once "../fachada.php";

                                      $dao = $factory->getDescarteDao();
                                      $descartes = $dao->buscaTodos();

                                      if ($descartes)
                                      {
                                          foreach ($descartes as $descarte)
                                          {
                                              $nome = $descarte->getNome();
                                              echo "<option value=\"" . $descarte->getId() . "\">" . $nome . "</option>";
                                          }
                                      }
                                  ?>
                              </select>
                        </div>
                    </div>    
                </form>
            </div>
          </section>
        </div>
        <div id="map"></div>
    <script>
      var customLabel = {
        restaurant: {
          label: 'R'
        },
        bar: {
          label: 'B'
        }
      };

        function initMap(selectObject) {

        var idResiduo;

        if (selectObject == null) {
          idResiduo = "";
        } else {
          idResiduo = selectObject.value;
        }

        var map = new google.maps.Map(document.getElementById('map'), {
          center: new google.maps.LatLng(-29.161358257719222, -51.15427341306435), // Endere??o da onde vai buscar o mapa
          zoom: 13
        });
        var infoWindow = new google.maps.InfoWindow;

          // Endere??o da onde vai buscar o mapa, aqui tem que ir os resultados
          downloadUrl('../resultado.php?idResiduo=' + idResiduo, function(data) {
            var xml = data.responseXML;
            var markers = xml.documentElement.getElementsByTagName('marker');
            Array.prototype.forEach.call(markers, function(markerElem) {
              var name = markerElem.getAttribute('name');
              var address = markerElem.getAttribute('address');
              var nome_descarte = markerElem.getAttribute('type');
              var point = new google.maps.LatLng(
                  parseFloat(markerElem.getAttribute('lat')),
                  parseFloat(markerElem.getAttribute('lng')));

              var infowincontent = document.createElement('div');
              var strong = document.createElement('strong');
              strong.textContent = name
              infowincontent.appendChild(strong);
              infowincontent.appendChild(document.createElement('br'));

              var text = document.createElement('text');
              text.textContent = "Endere??o: "  + address + " Tipo: " + nome_descarte 
              infowincontent.appendChild(text);
              var icon = customLabel[nome_descarte] || {};
              var marker = new google.maps.Marker({
                map: map,
                position: point,
                label: icon.label
              });
              marker.addListener('click', function() {
                infoWindow.setContent(infowincontent);
                infoWindow.open(map, marker);
              });
            });
          });
        }

     

      function downloadUrl(url, callback) {
        var request = window.ActiveXObject ?
            new ActiveXObject('Microsoft.XMLHTTP') :
            new XMLHttpRequest;

        request.onreadystatechange = function() {
          if (request.readyState == 4) {
            request.onreadystatechange = doNothing;
            callback(request, request.status);
          }
        };

        request.open('GET', url, true);
        request.send(null);
      }

      function doNothing() {}
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDBW8E85okZXZ1Wa3aSVof6QrGpdqCup6E&callback=initMap">
    </script>
    </section>
        <!-- Copyright Section-->
        <div class="copyright py-4 text-center text-white">
            <div class="container"><small>Copyright ?? Sorte Verde 2021</small></div>
        </div>
        <!-- Scroll to Top Button (Only visible on small and extra-small screen sizes)-->
        <div class="scroll-to-top d-lg-none position-fixed">
            <a class="js-scroll-trigger d-block text-center text-white rounded" href="#page-top"><i class="fa fa-chevron-up"></i></a>
        </div>
        <!-- Bootstrap core JS-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Third party plugin JS-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
        <!-- Contact form JS-->
        <script src="assets/mail/jqBootstrapValidation.js"></script>
        <script src="assets/mail/contact_me.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
  </body>
</html>
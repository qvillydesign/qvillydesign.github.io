<?php 
require_once($baseController->website_path . "/template/_header.php");

 ?>
  <style>
      #map {
        width: 100%;
        height: 400px;
        background-color: grey;
      }
      .maph3center{
      	text-align: center;
      	padding-bottom: 15px;
      }
    </style>

<section class="bg-img1 txt-center p-lr-15 p-tb-92" style="background-image: url('images/bg-01.jpg');">
		<h2 class="ltext-105 cl0 txt-center">
			Контакты
		</h2>
	</section>	

	<!-- Content page -->
	<section class="bg0 p-t-104 p-b-116">
		<div class="container">
			<div class="flex-w flex-tr">
				<div class="size-210 bor10 p-lr-70 p-t-55 p-b-70 p-lr-15-lg w-full-md">
					<form>
						<h4 class="mtext-105 cl2 txt-center p-b-30">
							Отправить сообщение
						</h4>

						<div class="bor8 m-b-20 how-pos4-parent">
							<input class="stext-111 cl2 plh3 size-116 p-l-62 p-r-30" type="text" name="email" placeholder="Ваш e-mai адрес">
							<img class="how-pos4 pointer-none" src="images/icons/icon-email.png" alt="ICON">
						</div>

						<div class="bor8 m-b-30">
							<textarea class="stext-111 cl2 plh3 size-120 p-lr-28 p-tb-25" name="msg" placeholder="Чем можем помочь?"></textarea>
						</div>

						<button class="flex-c-m stext-101 cl0 size-121 bg3 bor1 hov-btn3 p-lr-15 trans-04 pointer">
							Отправить
						</button>
					</form>
				</div>

				<div class="size-210 bor10 flex-w flex-col-m p-lr-93 p-tb-30 p-lr-15-lg w-full-md">
					<div class="flex-w w-full p-b-42">
						<span class="fs-18 cl5 txt-center size-211">
							<span class="lnr lnr-map-marker"></span>
						</span>

						<div class="size-212 p-t-2">
							<span class="mtext-110 cl2">
								Адрес
							</span>

							<p class="stext-115 cl6 size-213 p-t-18">
								г.Гомель 
							</p>
						</div>
					</div>

					<div class="flex-w w-full p-b-42">
						<span class="fs-18 cl5 txt-center size-211">
							<span class="lnr lnr-phone-handset"></span>
						</span>

						<div class="size-212 p-t-2">
							<span class="mtext-110 cl2">
								Телефон
							</span>

							<p class="stext-115 cl1 size-213 p-t-18">
								+375 29 890 16 08
							</p>
						</div>
					</div>

					<div class="flex-w w-full">
						<span class="fs-18 cl5 txt-center size-211">
							<span class="lnr lnr-envelope"></span>
						</span>

						<div class="size-212 p-t-2">
							<span class="mtext-110 cl2">
								Тех. поддержка
							</span>

							<p class="stext-115 cl1 size-213 p-t-18">
								bunker.onlene@gmail.com
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>	
	

	<!-- Map -->
	<div class="map">
		<h3 class="maph3center">Bunker.Online на карте</h3>
    <div id="map"></div>
	</div>
	 <script>
      function initMap() {
        var uluru = {lat: 52.4288191, lng: 30.9688698};
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 13,
          center: uluru
        });
        var marker = new google.maps.Marker({
          position: uluru,
          map: map
        });
      }
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyClKld2-SwEXnwsh8j6tgH7qd2VSkgcYsk&callback=initMap">
    </script>




 
 <?php

require_once($baseController->website_path . "/template/_footer.php");
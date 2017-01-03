<?php require "sections/header.php"; 

if(!isset($_GET["slug"])): 

    header( "location:" . get_url() ); die(1); 

else:

    $slug = $_GET["slug"]; 

endif;

$get = $vars->get_reg("empresas", array("slug"=>$slug)); 

?>

        <!-- ####################################ARTICLE#################################### -->
        <article>
            <section class="informations">
                <div class="grid">
                    <?php if( !$get ) : 
                            echo "<h1> Empresa Não Encontrada </h1><!--"; 
                        else:
                            $empresa = $get[1];
                    ?>  
                    <div id="data-company" class="col-7-12">
                    <?php if( $empresa->tipo == "pago" ): ?>
                        <div class="thumb">   
                            <img style="width:100%" src="<?= get_img_uri() ?>/clientes/logomarcas/<?= !empty($empresa->logo) && file_exists( "img/clientes/logomarcas/".($empresa->logo) ) ? ($empresa->logo) : 'default.png' ?>" />
                        </div>
                    <?php endif; ?>
                        <div class="data" style=" <?= $empresa->tipo == "gratis" ? 'margin-left:0' : '' ; ?> ">
                            <h1 class='font-big'><?= ucwords($empresa->nome) ?></h1>
                            <a href="<?= $base_url.'/categorias/'.$empresa->categoria ?>" class="category"> <?= $empresa->categoria ?> </a><br />
                            <div class="phones">
                                <i class="icon-phone"></i>
                                <?php $gs = json_decode( $empresa->fone ); if( !empty($gs) && is_array( $gs ) ): foreach( $gs as $key=> $fone): 
                                        $fone_link = preg_replace('/[^0-9,.]+/i', '', $fone);
                                        echo "<a href='tel:0".$fone_link."'>$fone</a>&nbsp &nbsp" ; 
                                    endforeach; endif;?>
                            </div>
                            <div class="address"><i class="icon-location"></i>
                               <?php 
                                !empty( $empresa->referencia ) ? $referencia = "(".$empresa->referencia.")" : $referencia = ""; 
                                !empty( $empresa->complemento ) ? $complemento = $empresa->complemento.", " : $complemento = ""; 

                               $endereco = 
                                $empresa->rua.", "
                               .$empresa->numero.", "
                               .$complemento
                               .$empresa->bairro." - "
                               .$empresa->cidade."/"
                               .$empresa->estado; 
                               ?>

                              <?= $endereco; ?>
                              <?= $referencia ?>
                            </div>
                           
                        </div>
                        <div class="clear"></div>
                        <div class="description">
                            <?= $empresa->descricao ?>
                        </div>
                       <!-- <div class="empresa-keywords">
                        <br />
                            <div class="key-arrow-action" data-status><span class="arrow">&#10148;</span> <h3>Palavras-Chave <span class="status">(Mostrar)</span></h3></div>
                            
                            <span class="keyword-list">
                                
                                <?php /*$expl = explode(",", $empresa->keywords); 

                                if( $expl && is_array($expl)) {
                                    foreach( $expl as $word) {
                                        echo "<a href='" . get_url() . "/keyword/". trim($word)."' target='_blank'> {$word} </a> ";
                                    }
                                }*/
                                ?>

                            </span>

                        </div> -->
                    </div>
                    <div class="col-5-12">
                        <div class="map">
                           
                           <?php
                            if(!empty($endereco)): ?>
                               
                                <a target="_blank" href="https://www.google.com.br/maps/place/<?= $endereco ?>">
                                    <div id="mapa-empresa"></div>
                                </a>
                                <script src="https://maps.googleapis.com/maps/api/js"></script>
                                <script>
                                    $(document).ready(function(){
                                    function initialize(lat,lng) {
                                        var map = document.getElementById('mapa-empresa');
                                        var local = new google.maps.LatLng(lat, lng);
                                        var mapOptions = {
                                        center: local, // variável com as coordenadas Lat e Lng
                                        zoom: 14,
                                        mapTypeId: google.maps.MapTypeId.ROADMAP,
                                        panControl: false,
                                        zoomControl: false,
                                        mapTypeControl: false,
                                        scaleControl: false,
                                        streetViewControl: false,
                                        overviewMapControl: false
                                       };
                                       var map = new google.maps.Map(map,mapOptions);
                                       // variável que define as opções do marcador
                                       var marker = new google.maps.Marker({
                                          position: local, // variável com as coordenadas Lat e Lng
                                          map: map,
                                          title:"Farol de Aveiro"
                                      });
                                    };
                                    $.post("http://maps.google.com/maps/api/geocode/json?address=<?= $endereco ?>&sensor=false",{},function(data){
                                       
                                       $( data ).each(function(i,obj){
                                            lat = obj.results[0].geometry.location.lat; 
                                            lng = obj.results[0].geometry.location.lng; 

                                            google.maps.event.addDomListener(window, 'load', initialize(lat,lng));
                                       })
                                    },'json');
                                })
                                </script>
                                
                            <?php endif ?>
                        </div>
                    </div>
                </div>
            </section>
            <style>
            #mapa-empresa {
                width:100%;
                min-height: 180px;
                cursor:pointer;
            }
            </style>
            <?php if( $empresa->tipo == "gratis" ) : 
                require "sections/banner_add.php" ; 
            endif ?>
            <?php if( $empresa->tipo == "pago" ) : ?>
                <section class="photos">
                    <div class="grid">
                        <div class="col-1-1">
                            <div id="slider" class='desktop-gallery'>
                                <div class="container">
                                  <div class="row">
                                    <div class="span12">
                                      <div id="main-slider" class="owl-carousel">
                                       <div class="item">
                                        <div class="grid">
                                         <?php $count = 1; 
                                         $gll = json_decode($empresa->galeria); 
                                         if( is_array($gll) ) array_filter( $gll );
                                         if( $empresa->galeria != "[]" && is_array($gll) ): 
                                         foreach( $gll as $imagem ) : ?>
                                                <?php if(url_exists(get_url() . "/img/galerias/".$imagem)): ?> <div class="col-1-6 photo"><img src="<?= get_url() ?>/img/galerias/<?= $imagem ?>"></div><?php endif; ?>
                                        <?php if($count % 6 == 0): ?></div></div><div class="item"><div class="grid"><?php endif ?>
                                        <?php $count++; endforeach; endif; ?>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="navigation">
                                    <a id="prev-1" class="btn prev"></a>
                                    <a id="next-1" class="btn next"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="slider" class='mobile-gallery'>
                        <div class="container">
                            <div class="row">
                                <div class="span12">
                                    <div id="empresas" class="owl-carousel">
                                        <?php
                                            $count = 1; 
                                            $gll = array_filter(json_decode($empresa->galeria)); 

                                            if( $empresa->galeria != "[]" && is_array($gll) ): 
                                                    foreach( $gll as $imagem )  : ?>
                                                        <div class="item">
                                                            <div class="grid">
                                                                <div class="col-1-6 photo mobile-photo"><img src="<?= get_url() ?>/img/galerias/<?= $imagem ?>"></div>
                                                            </div>
                                                        </div>
                                                        <?php $count++;
                                                    endforeach; 
                                                endif;
                                            ?>
                                    </div>
                                </div>
                                <div class="navigation">
                                    <a id="prev-2" class="btn prev"></a>
                                    <a id="next-2" class="btn next"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <section class="moreAbout">
                    <div class="grid grid-masonry">
                        <div class="col-1-3 masonry">
                        <?php $links = json_decode($empresa->links);
                        //$links = is_array( $links ) ? array_filter( $links ) : $links;
                         if(!empty($links) && $empresa->links != '{"outros":[""]}' && $empresa->links != '[]' && count($links) > 0 ) : ?>
                            <div class="about-section" id="link-block">
                                <h1> <i class="icon-link"></i> Links</h1>
                                    <div class="clear"></div>

                                <div class="links">
                                
                                    <?= isset($links->site) ? "<a target='_blank' href='". url_verify(  $links->site  )."'><div class=\"link site icon-globe\"></div></a>": ""; ?>
                                    <?= isset( $links->facebook ) ? "<a target='_blank' href='". url_verify($links->facebook)."'><div class=\"link facebook icon-facebook\"></div></a>" : "" ?>
                                    <?= isset( $links->twitter ) ? "<a target='_blank' href='".url_verify($links->twitter)."'><div class=\"link twitter icon-twitter\"></div></a>" : "" ?>
                                    <?= isset( $links->instagram ) ? "<a target='_blank' href='".url_verify($links->instagram)."'><div class=\"link instagram icon-instagramm\"></div></a>" : "" ?>
                                    <div class="clear"></div>

                                </div>
                                   
                               <?php if(isset($links->outros)) : foreach( array_filter( $links->outros ) as $outro ): ?>
                                    <div class='another-link' style="overflow:hidden">
                                        <a href="<?= url_verify( $outro ) ?>" target="_blank">
                                            <span class="link link-icon"></span> <?= url_verify( $outro ) ?> 
                                        </a>
                                    </div><p>
                                <?php endforeach; endif; ?>
                            </div>
                            <div class="clear"></div>
                        <?php endif; ?>

                        </div>
                        <div class="col-1-3 masonry">
                            <?php $facil = $empresa->facilidades; 
                            if( !empty($facil) && $facil != '[]' && $facil != 'null'): ?>
                                <div class="about-section" >
                                    <i class="icon-ok-circled"></i> <h1>Facilidades</h1>
                                    <div class="clear"></div>

                                    <ul>
                                        <?php $arr = array_filter( json_decode($facil) ); if(is_array($arr)) :
                                            $get_facilidades = $vars->get_reg("facilidades"); 
                                            foreach( $get_facilidades as $facil ) : if( in_array($facil->titulo, $arr)): 
                                            ?>
                                        <li>
                                            <div class="facility">
                                                <div class="icon"><img src="<?= get_url() ?>/img/icones/<?= empty($facil->icone) ? 'default_facilidade.png' : $facil->icone ?>" alt="<?= $facil->titulo ?>"></div>
                                                <h3> <?= $facil->titulo ?> </h3>
                                                <div class="clear"></div>
                                            </div>
                                        </li>
                                        <?php endif; endforeach ?>
                                    </ul>
                                </div>
                            <?php endif ?>
                        <?php endif ?></div>
                    
                        <!-- </div> -->
                        
                            <?php $arr = json_decode($empresa->pagamento) ;
                            $arr = is_array( $arr ) ? array_filter ( $arr ) : $arr;
                           
                            if( $arr && $empresa->pagamento != "[]" ): 
                                $get_pag = $vars->get_reg( 'pagamento' );
                            ?>
                         	<div class="col-1-3 masonry">
                                <div class="about-section" id="payment-block">
                                    <h1><i class="icon-dollar"></i> Formas de Pagamento</h1>
                                    <div class="clear"></div>

                                    <div class="payment">
                                        
                                         <?php foreach( $get_pag as $method ) {
                                           
                                            if( in_array($method->nome, $arr) ) { ?>
                                            <div class="line">
                                                <div class="icon-payment"><img src="<?= get_url() ?>/img/icones/<?= empty($method->icone) ? 'default.png' : $method->icone ?>"></div><span style='display:inline-block;' class='label'><?= $method->nome ?></span>
                                            </div>
        
                                            <?php }
                                        } ?>
                                    </div>
                                </div>
                            </div>
                              
                           
                            <?php endif; ?>

                           <?php if ( $empresa->funcionamento ): ?>
                            <div class="col-1-3 masonry">
                                <div class="about-section" id="functionament-block">
                                    <h1> <i class="icon-clock"></i> <span>Horários de Funcionamento</span> </h1>
                                    <div class="clear"></div>
                                    <span>
                                     <?php
                                    $array = json_decode( $empresa->funcionamento ); 
                                    $array = is_array( $array ) ? array_filter($array) : array();
                                    $now_time = strtotime('now'); 
                                                                        
                                    $now_day = date('D'); 
                                    $day_list = ['Mon'=>0,'Tue'=>1,'Wed'=>2,'Thu'=>3,'Fri'=>4,'Sat'=>5,'Sun'=>6];
                                    $now_day = $day_list[$now_day]; 
                                   
                                    if( isset( $array[$now_day] ) ) {

                                        $day = $array[$now_day]; 
                                        $openAA = $day[0][0];
                                        $closeAA = $day[1][0]; 
                                        $openBB = $day[0][1];
                                        $closeBB = $day[1][1];
                                        
                                        $openA = strtotime( $openAA.":00" );
                                        $closeA = strtotime( $closeAA.":00" );

                                        $openB = strtotime( $openBB.":00" ); 
                                        $closeB = strtotime( $closeBB.":00" );

                                        if( $now_time >= $openA && $now_time <= $closeA ) { 
                                            opnd( 'open', $openAA, $closeAA );
                                        } else {
                                        	if( $now_time >= $openB && $now_time <= $closeB ) {
                                            	opnd( 'open', $openBB, $closeBB );
                                         	} else {
                                            	opnd('close');
                                        	}
                                        }
                                    }

                                    ?></span>
                                    <?= load_timelist( $array ) ?>
                                </div>
                            </div>

                            <?php endif ?>

                            <?php if( $empresa->videos && is_array(json_decode($empresa->videos)) && $empresa->videos != '[]'): ?>
                                <div class="col-1-3 masonry">
	                                <div class="about-section" id="video-block">
	                                    <h1> <i class="icon-videocam"></i> Vídeo</h1>
                                    <div class="clear"></div>


	                                    <div class="more-info">
	                                        <iframe src="<?= json_decode($empresa->videos)[0] ?>" frameborder="0" allowfullscreen></iframe>
	                                    </div> 
	                                </div>
                                </div>
                            <?php endif ?>

                        </div>
                    </div> </div>
                </section>
            </article>
        <?php else: $g = $vars->db_query("SELECT * FROM empresas WHERE tipo='pago' and(categoria='" .$empresa->categoria. "')"); 
        if( $g ): ?>
        <!-- <article>
            <section class="recents">
                <div class="grid over-grid">
                    <div id="slider" class="slider">
                        <div class="container">
                          <div class="row">
                            <div class="span12">
                              <div id="empresas" class="owl-carousel empresas">
                                <div class="item">
                                    <div class="grid">
                                     <h1><span class="high" style="color:#FF9800"> Empresas </span> Similares </h1>

                                        <?php 
                                        /*$count = 1; 
                                        shuffle($g);
                                        $control = array();
                                        foreach( $g as $emp ): if(!in_array($empresa->nome,$g)): $control[] = $emp; ?>
                                            <?php if($emp->nome != $empresa->nome) : ?><div class="col-1-4 empresa">
                                                <div class="card-buss">
                                                    <div class="cover">
                                                        <img src="http://www.hellomagazine.com/imagenes/travel/201208299115/iconic-photographs-travel/0-45-151/egypt--a.jpg" alt="empresa X">
                                                        <span class='break'>
                                                            <?= $emp->nome ?>
                                                        </span>
                                                    </div>
                                                    <div class="description description-noimage">
                                                        <span class="addr"><?= $emp->endereco ?> - <?= $emp->cep ?></span><br>
                                                        <span class="tel">
                                                            <?php if( $emp->fone && is_array(json_decode($emp->fone))): foreach(json_decode($emp->fone) as $fone) : ?>
                                                                <a href="tel:55<?= preg_replace("([(  )-])","",$fone) ?>"><?= $fone ?></a>
                                                            <?php endforeach; endif; ?>
                                                        </span><br>
                                                        <a href="#"><span class="category"><?= $vars->get_reg("categorias",array("slug_categoria"=> $emp->categoria ) )[1]->nome_categoria ?></span></a><br>
                                                        <?= ($emp->slug) ? "<a href='".get_url()."/empresa/".$emp->slug."' class='link'>+</a> ": ""; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php if( $count % 4 == 0  ): ?>
                                            </div></div><div class="item"><div class="grid">
                                       <?php endif; $count++; if($count >=8 ): break; endif; endif; endif; endforeach*/;  ?>
                                    </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="navigation">
                            <a id="prev-2" class="btn prev"></a>
                            <a id="next-2" class="btn next"></a>
                        </div>
                    </div>
                </div>
            </section> -->
        <!-- </article> -->
        </div>
        <section class="recents">
        <div class="grid over-grid">
            <h1 style="margin-top:0;text-align:center;color:#FF9800"> Empresas Similares </h1>
            <div id="slider2">
                <div class="container">
                  <div class="row">
                    <div class="span12">
                    <div id="empresas" class="owl-carousel empresas">
                        <?php 
                        $count = 1; 
                        shuffle($g);
                        echo $vars->get_error();
                        $control = array();
                        foreach( $g as $empresa ): $control[] = $empresa; if( $empresa->img_fachada != "" ): 
                            if( file_exists('img/clientes/logomarcas/'.$empresa->logo ) ) : $img = $empresa->logo; else: $img='default.png'; endif;
                        ?>
                            
                            <div class="empresa">
                           
                                <div class="card-buss">
                                    <div class="cover">
                                        <img src="<?= get_url() ?>/img/clientes/logomarcas/<?= $img ?>" alt="<?= $empresa->nome ?>">
                                        <a href="<?= get_url() ?>/empresa/<?= $empresa->slug ?>"><span class='break'>
                                            <?= $empresa->nome ?>
                                        </span></a>
                                    </div>
                                    <div class="description description-noimage">
                                        <span class="addr"><?= $empresa->rua.", ".$empresa->numero.", ".$empresa->bairro.", ".$empresa->cidade."/".$empresa->estado ?> - <?= $empresa->cep ?></span><br>
                                        
                                        <?php !empty( $empresa->complemento ) ? "<p> Complemento: " .  $empresa->complemento : "" ?> 


                                        <a href="#"><span class="category"><?php $a = $vars->get_reg("categorias",array("slug_categoria"=> $empresa->categoria ) ); @isset( $a[1]->nome_categoria ) ? $a[1]->nome_categoria : ""; ?></span></a><br>
                                        
                                       <?= ($empresa->slug) ? "<a href='".get_url()."/empresa/".$empresa->slug."' class='link'>+</a> ": ""; ?>
                                       
                                    </div>
                                </div>
                            </div>
                        <?php $count++; if($count > 8 ): break; endif; endif; endforeach; ?>
                    </div>
                    </div>
                  </div>
                </div>
                <div class="navigation">
                    <a id="prev-2" class="btn prev"></a>
                    <a id="next-2" class="btn next"></a>
                </div>
            </div>
        </div>
    </section>
        <?php endif; endif;?>
      <?php endif ?>
     <?php require "sections/footer.php"; ?>
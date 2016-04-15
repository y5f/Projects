
$(document).ready(function(){
    //-- On calcul el top ----
    var top1=$('.g-head').innerHeight()-13;
    var top2=$('.g-head').innerHeight() + $('.slide').innerHeight()-($('.sous-bloc').innerHeight()+32);
    var xsmall=false; //--- Si l'affichage est en mode small ---
    var small=false; //--- Si l'affichage est en mode small ---
    var md=false; //--- Si l'affichage est en mode small ---
    var lg=false; //--- Si l'affichage est en mode small ---
    var isBlock=false; //--- Si le block commentaire doit etre visible
    var idSousmenu; //-- L'id du soumenu à afficher lorsqu'on scrool la page ---
                    //--- partie détails (pas page d'accueil ------
        
    var cmptItem=0;
    var idx=0;
   
    //-- Position du menu et des blocs ----
    loard_menu();
    var Clock={
        start:function(){
            this.interval=setInterval(function(){slide_show();}, 5500);
        },
        pause:function(){
            clearInterval(this.interval);
            delete this.interval;
        },
        resume:function(){
            if(!this.interval)this.start();
        }
    };
    
    Clock.start();
    
   //---- CE BOUT DE CODE GERE LES BOUTON DE NAVIGATION PREC & SUIV ---
    $('.nav').mouseover(function(){
        $('.nav').css({
            'border':'solid 0.1em rgba(34,66,124,0.9)'
        });
        $(this).css({
            'border':'solid 0.1em rgba(139,0,0,0.9)'
        });
    });
    $('.nav').mouseleave(function(){
        $('.nav').css({
            'border':'solid 0.1em rgba(34,66,124,0.9)'
        });
    });
    
    //------------------------
    //----- Qaund on clique sur les bouton de nav ----
    //--- On arrete le slider quand on clique sur prec ou suiv --
    $('.nav').click(function(){
        //alert('ok');
        Clock.pause();
        deplace($(this).attr('name'));
    });
    //--- Quand la souris entre dans la fenetre ----
    //----  on met le slider en pause ------
    $('.film-tr').mouseover(function(){
        Clock.pause();
    });
    
    //--- Quand la souris quitte la fenetre slideshow, on relance le slider ---
    $('.film-tr').mouseleave(function(){
        Clock.resume();
    });
    
    //-- On cache/ouvre le bloc article -------
    $('.article').mouseover(function(){
        $('.article p').animate({marginBottom:'0'},400);
    });
    $('.article').mouseleave(function(){
        $('.article p').animate({marginBottom:'-60%'},400);
    });
    
    //-- On cache/ouvre le bloc reglement -------
    $('.reg').mouseover(function(){
        $('.reg p').animate({marginBottom:'0'},400);
    });
    $('.reg').mouseleave(function(){
        $('.reg p').animate({marginBottom:'-60%'},400);
    });
    
    //-- On cache/ouvre le bloc helico à vendre -------
    $('.helico').mouseover(function(){
        $('.helico p').animate({marginBottom:'0'},400);
    });
    $('.helico').mouseleave(function(){
        $('.helico p').animate({marginBottom:'-60%'},400);
    });
    //-- On cache/ouvre le stock -------
    $('.b-stock').mouseover(function(){
        $('.b-stock p').animate({marginBottom:'0'},400);
    });
    $('.b-stock').mouseleave(function(){
        $('.b-stock p').animate({marginBottom:'-60%'},400);
    });
    //-- On cache/ouvre le bloc libre -------
    $('.libre').mouseover(function(){
        $('.libre p').animate({marginBottom:'0'},400);
    });
    $('.libre').mouseleave(function(){
        $('.libre p').animate({marginBottom:'-70%'},400);
    });
    //-- On cache/ouvre le bloc partenaire -------
    $('.pt').mouseover(function(){
        $('.pt p').fadeIn(100);
    });
    $('.pt').mouseleave(function(){
        $('.pt p').fadeOut(100);
    });
    //--- Ce code gère la position du menu en fonction de l'ecran d'affichage ---
    $(window).resize(function(){
        loard_menu();
    });
    
    $(window).scroll(function(){
        
        loard_menu();
 
    });
    
    //--- Si la souris survole un menu-- le menu principal ----
    $('.m-bloc').mouseover(function(){
        //alert('ok')
        $(this).css({
            'cursor':'pointer'
        });
    });
    
    $('.m-bloc').click(function(){
        
        $('.bloc').css({
            'display':'none'
        });
        $.ajax({
            type:"POST",
            url:'scripts/script.php',
            data:"cat=" + $(this).attr('name'),
            success :showMenu
        });
        
        //--- On cache une eventuelle affichae de sous menu ---//
        $('.port-form').css({
            'display':'none'
        });
        var id=$(this).attr('name');
        $('.menu-details').css({
            'display':'block'
        });
        $('.d-menu').css({
            'display':'none'
        });
        $('#' + id).css({
            'display':'block'
        });
        
        idSousmenu=id;
    });
    
    //-- Quand on passe la souris sur un boc d'un appareil ---
    //--- le text de description de celui-ci s'ouvre ----//
    
    $('.details').mouseover(function(){
        var id=$(this).attr('name');
        //alert(id)
        $('#' + id).css({
            'margin':'-17.0em auto'
        });
    });
    $('.details').mouseleave(function(){
        var id=$(this).attr('name');
        //alert(id)
        $('#' + id).css({
            'margin':'auto'
        });
    });
    
    //-- Quand on clique sur le lien refrech ---//
    $('.refresh').click(function(){
        refreshCaptcha();
    });
    $('.refresh').mouseover(function(){
        $(this).css({
            'cursor':'pointer',
            'text-decoration':'underline'
        });
    });
    
    $('.refresh').mouseleave(function(){
        $(this).css({
            'text-decoration':'none'
        });
    });
    //--- Fonction de deplacement -----
    function deplace(ele){
       //-- On recupère la valeur de la marge ---
       if(ele==='prec'){
           if(cmptItem>=100){
            cmptItem=cmptItem-100;
           }else{
            cmptItem=400;
           }
           
       }else{
           if(cmptItem<=300){
            cmptItem=cmptItem+100;
           }else{
            cmptItem=0;
           }
           
       }

        $(".slider").animate({marginLeft:-cmptItem+'%'},200,function(){
            show_coment();
        });
        hide_coment();
    }
    
    //--- Fonction de deplacemment ----
    function slide_show(){
        //--- On calcul l'Item encours ----
        if(cmptItem<400){
           cmptItem=cmptItem+100;
        }else{
           cmptItem=0;
        }
        
        //-- On calcul l'index qui repère les bouton de navigation ---
        idx++;
        if(idx>5)idx=1;
        
        $(".slider").animate({marginLeft:-cmptItem+'%'},200,function(){
            show_coment();
        });
        hide_coment();
    }
    
    //-- Cette fonction affiche le comentaire du slideshow ---
    function show_coment(){
        //alert(id);
        if(isBlock){
            $('.coment').fadeIn(200);
        }
    }
    function hide_coment(){
        if(isBlock){
            $('.coment').fadeOut(1);
        }
    }
    
    //--- On charge le map ----
    if($('#map').length){
        map = new google.maps.Map(document.getElementById("map"), {
            zoom: 19,
            center: new google.maps.LatLng(43.3210864, 5.382739500000071),
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });
    }
   
    //--- Cett fonction positionne le menu en fonction de l'ecran ---
    function pose_menu(){
        
        if($(window).width()<=760){
            $('.titre').css({
                //'margin':'0.1em 0.8em'
            });
            $('.sous-bloc').css({
                //'margin':'auto'
            });
            $('.reg').css({
                'width':'100%'
            });
            $('.network').css({
                'width':'70%'
            });
            $('.helico img').css({
                'width':'100%'
            });
            $('.b-stock img').css({
                'width':'100%'
                //'margin':'auto'
            });
            $('.libre img').css({
                'width':'100%'
                //'margin':'auto'
            });
            xsmall=true;
            small=false;
            md=false;
            lg=false;
        }
        
        if($(window).width()>760){
            $('.reg').css({
                'width':'40%'
            });
            $('.helico img').css({
                'width':'96%'
            });
            $('.b-stock img').css({
                'width':'95%'
            });
            
            $('.helico p').css({
                'width':'96%'
            });
            $('.b-stock p').css({
                'width':'95%'
            });

            if($(window).width()<1000){
                $('.titre').css({
                    //'margin':'0.1em 0.8em'
                });
                $('.network').css({
                    'width':'57%'
                });
                $('.sous-bloc').css({
                    //'margin':'auto'
                });
                $('.coment,.coment-slide').css({
                    'display':'none'
                });
                
                small=true;
                xsmall=false;
                md=false;
                lg=false;
            }else if($(window).width()<1200){
                $('.titre').css({
                    //'margin':'0.1em 0.8em'
                });
                $('.network').css({
                    'width':'44%'
                });
                $('.coment,.coment-slide').css({
                    'display':'block'
                });
                md=true;
                xsmall=false;
                small=false;
                lg=false;
                
            }else{
                $('.titre').css({
                    //'margin':'0.1em 20.8em'
                });
                $('.network').css({
                    'width':'37%'
                });
                $('.sous-bloc').css({
                    //'margin':'auto'
                });
                lg=true;
                xsmall=false;
                small=false;
                md=false;
            }
        }
    }
    
    //--- Cette fonction controle si le menu atteint la zone du logo ---
    function menu_attache(){
        var scroll = $(window).scrollTop();
        //alert(scroll);
        var win_height = $( window ).height();
        var win= win_height+scroll;
        if($('.panneau')){
            if($('.panneau').offset()){
                var elem=$('.panneau').offset().top;
                    if (win>elem) {
                        var diff=elem-win;
                        var limite=$('.slide').innerHeight() - $('.menu').innerHeight() - $('.g-head').innerHeight() - 162;
                        if(diff<=-limite){
                            //alert('alte1');
                            return true;
                        }else{
                            //alert('alte2');
                            return false;
                        }
                    }
            } else{
                return win;
            }
        }
        
    }
    
    //--- Cette fonction calcule le top en fonction de l'affichage ecran ---
    function top_calcul(){
        
        pose_menu();
        
        if(xsmall){
            top2=$('.g-head').innerHeight() + 524;
        }else{
            var cons=0;
            if(small){
                cons=170;
            }else if(md){
                cons=170;
            }else if(lg){
                cons=105;
            }
            //alert(cons);
            top2=$('.g-head').innerHeight() + $('.slide').innerHeight()-($('.sous-bloc').innerHeight()+cons);
        }
    }
    
    //--- Cette fonction est appelée au chargement de la page et au deroulement de la page ---
    function loard_menu(){
        //alert('ok');
        top_calcul();
        //--- Calcul de la positio top en fonction de l'affichage ecran ---
        if(menu_attache()===true){
           
            $('.menu').css({
                'position':'fixed',
                'top':top1
            });
        }else{
            
            $('.menu').css({
                'position':'absolute',
                'top':top2
            });
            
            var dist=top2 + menu_attache();
            //alert(dist);
            if(dist>=$('.portfolio').innerHeight()){
                $('#' + idSousmenu).fadeOut(400);
            }else{
                $('#' + idSousmenu).fadeIn(400);
            }
            
        }
        
    }
    
    //--- On modifie le lien vers l'article actualité sur le site indiqué ---
    var newLien=$('#lien').attr('cible') + $('.article a').attr('href');
    $('.article a').attr('href',newLien);

    //-- On rajoute un lien sur la bande deroulante ---
    var newParag=document.createElement('a');
    newParag.setAttribute('href',newLien);
    newParag.appendChild($('.article p')[0]);
    
    //--- On 
    $('.article').append(newParag);
    
    //-- On cache le texte indesirable --//
    $('.article h3').css({'display':'none'});
    //alert(newParag.innerHTML);
    
    
    //--- Fonction appelée lorsqu'on rafraichi le captcha ---//
    function refreshCaptcha(){
        var img = document.images['captchaimg'];
        img.src = img.src.substring(0,img.src.lastIndexOf("?"))+"?rand="+Math.random()*1000;
    }
    
    //--- Cette fonction affiche le resultat retourné par la requette ajax ---//
    function showMenu(rslt){
        //alert('ok');
        $('.menu-details').html(rslt);
    }
});

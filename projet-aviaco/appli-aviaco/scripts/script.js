//---- Appel de la fonction load qui initialise je jq ---//
load();
function load(){
    $(document).ready(function(){
    
        var idx_control=true;
        //ajax_load('societe');
    
        //################ SRIPT TRAITANT LES MENU DE LA COLONNE ##########
        //------------------------

        $('.it').click(function(){
            var id=$(this).attr('name');
            $('#'+id).slideToggle(0);
        });
        //--- Si on ne clique pas sur les sous-rub --//
        //------ n ferme les details rubb--------
        $('.itp').click(function(){
            var id=$(this).prop('class').split(' ')[1];
            $('#'+id).fadeOut(1);
            $('.itp').css({
                'color':'rgba(0,121,175,1.0)'
            });
        
            $(this).css({
                'color':'crimson'
            });
        
        });
        function refrechform(rslt){
            $('.middle').html(rslt);
            load();
        }
        //########## SCRIPT TRAITANT LE MENU DE DECONNEXION ###########
        //---------------:
        $('#h-user-bh').click(function(){
            $('#dec-ul').slideToggle(300);
        });
    
        //################### SCRIPT TRAITANT LE BOUTON ON/OFF ###########
        //################################################################
        $('.b-on-off').draggable({
            containment:'.f-alert',
            axis:'x'
        });

        $('.f-alert').droppable({
            accept:'.b-on-off',
            drop:dragg
        });

        function dragg(e,ui){
            
            var element=$(ui.draggable);
            if(element.attr('etat')==='1'){
                element.attr('id','b-off');
                element.attr('etat','0');
                element.css({'left':'auto'});
                element.css({'right':'0'});
                $("#f-zone").val("FALSE");
                dp=true;
            }else{
                element.attr('id','b-on');
                element.attr('etat','1');
                element.css({'left':'0'});
                $('#f-zone').val("TRUE");
                var dp=false;
            }
            if(dp){
                //--- On envoi une requette mettant àjour l'infos --
                var num_soc=$('#num-soc').val();
                if(num_soc){
                    $.ajax({
                        type:'POST',
                        url:'scripts/script.php',
                        data:'fraude-form=' + num_soc,
                        success:add_form
                    });
                }
            }else{
                $('#MyIg').html('');
                upload_fraude('1');
            }
        }
        $('#add-fraude').click(function(){
            var plaing_num=$('.p-plainte:checked').map(function(){return $(this).val();}).get().join('^');
            if(!plaing_num){
                alert('Vous devez choisir une société plaignante !');
                return null;
            }
            var num_soc=$('#num-soc').val();
            var plaing_name=$('#plaignant').val();
            $.ajax({
                type:'POST',
                url:'scripts/script.php',
                data:'add-fraude=' + num_soc + '^' + plaing_num + '^' + plaing_name,
                success:upload_fraude
            });
        });
        function upload_fraude(rslt){
            //alert(rslt)
            if(rslt==='1'){
                //--- On envoi une requette mettant àjour l'infos --
                var num_soc=$('#num-soc').val();
                if(num_soc){
                    $.ajax({
                        type:'POST',
                        url:'scripts/script.php',
                        data:'save-fraude=' + num_soc + '#' + $('#f-zone').val(),
                        success:refreshhist
                    });
                }
            }
        }
        //############# SCRIPT TRAITANT LE CHARGEMENT DU LOGO ################
        //####################################################################
        $('#logo-soc').click(function(){
            //alert('ok')
            myLoard(0);
        });
    
        //##################### SCRIPT TRAITANT LA SAVE DES INFOS SOC ########
        //#####################################################################
        $('#save-infos').click(function(){
            var num_soc=$('#num-soc').val();
            var form=$('#new-part');
            if(!num_soc){
                form.attr('action','scripts/script.php');
                $.ajax({
                    type:form.attr('method'),
                    url:form.attr('action'),
                    data:form.serialize(),
                    success:saveHistorique
                });
            }
        });
        $('#updt-infos').click(function(){
            var form=$('#new-part');
            form.attr('action','scripts/script.php');
            $.ajax({
                type:form.attr('method'),
                url:form.attr('action'),
                data:form.serialize(),
                success:saveHistorique
            });
        });
        $('.hist-sel').click(function(){
            saveHistorique();
        });
        function saveHistorique(){
            var num_soc=$('#num-soc').val();
            if(num_soc){
                var hist=$('.hist-sel:checked')
                    .map(function(){return $(this).val();})
                    .get().join('#');
                $.ajax({
                    type:'POST',
                    url:'scripts/script.php',
                    data:'save-hist=' + num_soc + '#' + hist,
                    success:refreshhist
                });
            }
            
        }
        function refreshhist(rslt){
            window.location.reload();
        }
        //##################### SCRIPT TRAITANT LA SAVE DES CONTACT ############
        //######################################################################
        $('#save-cont').click(function(){
            var num_soc=$('#num-soc').val();
            var form=$('#new-part');
            form.attr('action','scripts/script.php');
            if(!num_soc){
                $.ajax({
                    type:form.attr('method'),
                    url:form.attr('action'),
                    data:form.serialize()
                });
            }
            
        });

        //#####################SCRIPT TRAITANT LES CERTIFICATS #################
        //######################################################################
        $('.add-cert').click(function(){
            //var form=$('.certificat');
            //form.attr('action','script.php');
            var ch1=$('input[name=agrement]').val();
            var ch2=$('input[name=src]').val();
            if(!(ch1 && ch2)){
                return null;
            }  
            checkeditems = $('.ids:checked')
                       .map(function() { return $(this).val();})
                       .get()
                       .join("^");
            if(checkeditems.length===0){
                alert('Veuillez choisir au moins un appareil');
                return false;
            }
            var id=$('#id-cert').val();
            var data=id +'^' + ch1 + '^' + ch2 + '^' + checkeditems;
            $.ajax({
                type:'POST',
                url: 'scripts/script.php',
                data:'ids='+data,
                success:reponse_infos
            });
        });
        $('.item-cert').click(function(){
            $('.item-cert').css({'text-decoration':'none'});
            $(this).css({'text-decoration':'underline'});
            
            var id=$(this).attr('value');
            $.ajax({
                type:'POST',
                url: 'scripts/script.php',
                data:'get-cert='+id,
                success:refreshcert
            });
        });
        $('.supcert').click(function(){
            var id=$('#id-cert').val();
            if(id){
                if(confirm('Voulez-vous supprimer ce certificat ?')){
                    $.ajax({
                        type:'POST',
                        url: 'scripts/script.php',
                        data:'del-cert='+id,
                        success:refreshlist
                    });
                }
            }
        });
        function refreshcert(rslt){
            var str=rslt.split('#');
            var infos=str[0].split('^');
            $('#id-cert').val(infos[0]);
            $('#agrement').val(infos[1]);
            $('#src-cert').val(infos[2]);
            
            $('.div-list-ap').html(str[1]);
            
        }
        function refreshlist(rslt){
            if(rslt!==''){
                $('#list-cert').html(rslt);
            }
        }
        //###################### SCRIPT TRAITANT LES ACTIVITES DE LA SOC #######
        //######################################################################
        /*
        $('.b-act li').click(function(){
           $(' .b-act li').css({
               'background-color':'transparent',
               'color':'rgba(46,46,46,0.9)'
           });
           $(this).css({
               'background-color':'indigo',
               'color':'#FEFEFE'
           });
        });
        */
        $('.it-agr').click(function(){
            var agr=$('#num-soc').val()+'#';
            var etat='0';
            if($(this).is(':checked')){
                etat='1';
            }
            agr+=etat+'#';
            agr+=$(this).val();
            $.ajax({
                type:'POST',
                url: 'scripts/script.php',
                data:'d-cert='+agr,
                success:reponse_infos
            });
        });
        $('.act-sel').click(function(){
            var metier=$('#num-soc').val()+',';
            metier+=$('.act-sel:checked')
                       .map(function() { return $(this).val();})
                       .get()
                       .join(",");
            $.ajax({
                type:'POST',
                url: 'scripts/script.php',
                data:'save-metier='+metier,
                success:reponse_infos
            });
        });
        $('.tp-sel').click(function(){
            var tp=$('#num-soc').val()+',';
            tp+=$('.tp-sel:checked')
                       .map(function() { return $(this).val();})
                       .get()
                       .join(",");
            $.ajax({
                type:'POST',
                url: 'scripts/script.php',
                data:'save-tp='+tp,
                success:reponse_infos
            });
        });
        $('.it-stk').click(function(){
            var stk=$('#num-soc').val()+',';
            stk+=$('.it-stk:checked')
                       .map(function() { return $(this).val();})
                       .get()
                       .join(",");
            $.ajax({
                type:'POST',
                url: 'scripts/script.php',
                data:'save-stk='+stk,
                success:reponse_infos
            });
        });
        $('.it-flotte').click(function(){
            var stk=$('#num-soc').val()+',';
            stk+=$('.it-flotte:checked')
                       .map(function() { return $(this).val();})
                       .get()
                       .join(",");
            $.ajax({
                type:'POST',
                url: 'scripts/script.php',
                data:'save-flotte='+stk,
                success:reponse_infos
            });
        });
        $('.it-fbr').click(function(){
            var stk=$('#num-soc').val()+',';
            stk+=$(this).val();
            $.ajax({
                type:'POST',
                url: 'scripts/script.php',
                data:'save-fbr='+stk,
                success:reponse_infos
            });
        });
        $('#save-note').click(function(){
            var note=$('#num-soc').val()+'#'+$('.note-act').val();
            $.ajax({
                type:'POST',
                url: 'scripts/script.php',
                data:'save-note='+note,
                success:reponse_infos
            });
        });
        $('.it-cert').click(function(){
            var id=$(this).val();
            var val='0';
            if($(this).is(':checked')){
                val='1';
            }
            $.ajax({
                type:'POST',
                url: 'scripts/script.php',
                data:'save-app-cert='+id+'#'+val,
                success:reponse_infos
            });
        });
        $('#mro-add').click(function(){
            var ids=$('#num-soc').val()+'#';
            ids+=$('.it-mro:checked')
                    .map(function(){return $(this).val();})
                    .get()
                    .join('#');
            $.ajax({
                type:'POST',
                url: 'scripts/script.php',
                data:'save-mro='+ids,
                success:reponse_infos
            });
        });
        $('.it-mro-det').click(function(){
            var id=$(this).val();
            var val='0';
            if($(this).is(':checked')){
                val='1';
            }
            $.ajax({
                type:'POST',
                url: 'scripts/script.php',
                data:'save-mro-cert='+id+'#'+val,
                success:reponse_infos
            });
        });
        $('#file-browser').click(function(){
            $.ajax({
                type:'POST',
                url: 'scripts/script.php',
                data:'open-cert='+$(location).attr('href'),
                success:add_form
            });
        });
        //########################## SCRIPT TRAITANT LES INFOS FINANCIERES DE LA SOCIETE ###########
        //############################################################################
        $('#save-fin').click(function(){
            var num_soc=$('#num-soc').val();
            var form=$('#new-part');
            form.attr('action','scripts/script.php');
            if(num_soc){
                $.ajax({
                    type:form.attr('method'),
                    url:form.attr('action'),
                    data:form.serialize(),
                    success:reponse_infos
                });
            }
        });
        
        //------------ Ajout chiffre d'affaire ---//
        $('#add-ca').click(function(){
            $.ajax({
                type:'POST',
                url: 'scripts/script.php',
                data:'add-ca='+$(location).attr('href'),
                success:add_form
            });
        });
        $('#ca-close').click(function(){
            $('#MyIg').html('');
        });
        
        var index=0; //--- Cet index permet de rajouter des zone de saisie pour les CA --
        $('.addButton').click(function(){
            if(index<5){
                index++;
                var $template = $('#first-tr');
                
                $clone = $template
                                .clone()
                                .removeClass()
                                .attr('id','tr'+index)
                                .attr('class','delete tr')
                                .insertAfter($template);

            $clone
                .find('[name="a0"]').attr('id', 'a'+index).end()
                .find('[name="c0"]').attr('id', 'c'+index).end()
                .find('[name="n0"]').attr('id', 'n'+index).end()
                .find('[name="f0"]').attr('id', 'f'+index).end()
                .find('[type="button"]').attr('class','del');
            }
            
        }); 
        $('.sub-chiffre').click(function(){
            var data=$('#num-soc').val()+'#';
            //  récuperer le nombre des lignes
            var nb_tr=$('.tr').length;
            for(i=0;i<nb_tr;i++){
                var annee=$('#a'+i).val();
                var chiffre=$('#c'+i).val();
                var nb_emp=$('#n'+i).val();
                var fil=$('#f'+i).prop('checked');
                if(!(annee)){
                    alert('annee,chiffre d\'affaire,nombre employés: obligatoires');
                    return null;
                }
                data+=annee+'@'+chiffre+'@'+nb_emp+'@'+fil+'#';
            }
    
            $.ajax({
                type:'POST',
                url:'scripts/script.php',
                data:'new-ca='+data,
                success:reponse_infos
            });
    
        });
        $('#add-src-web').click(function(){
            $.ajax({
                type:'POST',
                url: 'scripts/script.php',
                data:'add-src-web='+$('#num-soc').val(),
                success:add_form
            });
        });
        $('.but-src').click(function(){
            if(!$('#src-web').val()){
                return null;
            }
            var data=$('#num-soc').val()+'#'+$('#desc-web').val()+'#'+$('#src-web').val();
            $('#src-web').val('');
            
            $.ajax({
                type:'POST',
                url: 'scripts/script.php',
                data:'add-src='+data,
                success:refreshweb
            });
        });
        $('.del-web').click(function(){
            var id=$(this).attr('value');
            $.ajax({
                type:'POST',
                url: 'scripts/script.php',
                data:'del-web='+$('#num-soc').val()+'#'+id,
                success:refreshweb
            });
        });
        function refreshweb(rslt){
            //alert(rslt)
            $('#add-src').html(rslt);
            load();
        }
        $('#add-rib').click(function(){
            $.ajax({
                type:'POST',
                url: 'scripts/script.php',
                data:'add-rib-form='+$('#num-soc').val(),
                success:add_form
            });
        });
        /*
        $('.but-rib').click(function(){
            var form=$('#page-src');
            form.attr('action','scripts/script.php');
            $.ajax({
                type:'POST',
                url: form.attr('action'),
                data:form.serialize(),
                success:reponse_infos
            });
        });
        */
        $('.act-soc').click(function(){
            var num_soc=$('#num-soc').val();
            var nom=$(this).attr('name');
            if(nom==='del'){
                if(!confirm('Voulez-vous supprimer cette société ?')){
                    return null;
                }
            }
            if(nom==='act'){
                if(!confirm('Voulez-vous activer cette société ?')){
                    return null;
                }
            }
            if(nom==='desact'){
                if(!confirm('Voulez-vous désactiver cette société ?')){
                    return null;
                }
            }
            $.ajax({
                type:'POST',
                url: 'scripts/script.php',
                data:'op-soc=' + nom + '^' +num_soc
            });
            
        });
       //################ SCRIPT TRAITANT LA LISTE DES PAYS ####################
       //#######################################################################
       $('.new-pays').click(function(){
           $.ajax({
                type:'POST',
                url: 'scripts/script.php',
                data:'open-pays='+$('#num-soc').val(),
                success:add_form
            });
       });
       $('.but-pays').click(function(){
           var pays=$('#select-pays').val();
           $.ajax({
                type:'POST',
                url: 'scripts/script.php',
                data:'add-pays='+pays,
                success:reponse_infos
            });
       });
        function add_form(rslt){
            $('#MyIg').html(rslt);
            load();
        }
        
        //################## SCRIPT TRAITANT LE FILTRE #############################
        //##########################################################################
        $('.item-pays').click(function(){
            $('.item-pays').attr('etat','0');
            $(this).attr('etat','1');
        });
        
        $('.filtre').click(function(){
        
            //--- Recuperation du pays --//
            var p='';
            $('.item-pays').each(function(){
                if($(this).attr('etat')==='1'){
                    p=$(this).attr('value');
                }
            });
        
            //--- Recuperation du fabricant ---
            var fab=$('.f-list:checked')
                       .map(function() { return $(this).val();})
                       .get()
                       .join(",");
        
            //--- Recuperation des activités ---
            var act = $('.act-list:checked')
                       .map(function() { return $(this).val();})
                       .get()
                       .join(",");
            //--- Recuperation des appareils/pieces ---
            var app=$('.app-list:checked')
                       .map(function() { return $(this).val();})
                       .get()
                       .join(",");
        
            //---- Recuperation des appareil flotants --//
            var app_flt=$('.app-f-list:checked')
                       .map(function() { return $(this).val();})
                       .get()
                       .join(",");
            var requete=p+'#'+fab+'#'+act+'#'+app+'#'+app_flt;
        
            //---- Envoie de la requette via ajax -------
            $.ajax({
                type:'POST',
                url: 'scripts/script.php',
                data:'search-soc='+requete,
                success:get_soc
            });
        });
        function get_soc(rslt){
            //alert(rslt)
            $('#liste-filtre').html(rslt);
        }
        $('#b-filtre').click(function(){
            var list=$('.item-ep')
                    .map(function(){return $(this).attr('value');})
                    .get().join('#');
            $.ajax({
                type:'POST',
                url: 'scripts/script.php',
                data:'search-list='+list,
                success:refrechform
            });
        });
        //############## SCRIPT TRAITANT LA FENETRE RESULTAT ######################
        //#########################################################################
        $('.all-mail').click(function(){
            if($(this).is(':checked')){
                $('.mail-sel').prop('checked',true);
            }else{
                $('.mail-sel').prop('checked',false);
            }
        });
        $('.c-all-mail').click(function(){
            if($(this).is(':checked')){
                $('.c-mail-sel').prop('checked',true);
            }else{
                $('.c-mail-sel').prop('checked',false);
            }
        });
        $('.del-soc-all').click(function(){
            if($(this).is(':checked')){
                $('.del-soc').prop('checked',true);
            }else{
                $('.del-soc').prop('checked',false);
            }
        });
        $('#result-act:first').change(function(){
            
            if($(this).val()!=='aucun'){
                if($(this).val()==='mailing'){
                    var mail=$('.mail:checked').map(function(){return $(this).val();}).get().join(',');
                    var adress=$('.mail:checked').map(function(){return $(this).attr('name');}).get().join(',');
                    var form='<div id=mailing>';
                    form+='<hgroup>' + mail + '</hgroup>';
                    form+='<em class=close-mail>Ferme</em>';
                    form+='<a href=mailto:'+ adress +' class=close-mail>Envoyer un mail >>></a>';
                    form+='</div>';
                    $('#MyIg').html(form);
                    load();
                }
                
                if($(this).val()==='del'){
                    if(!confirm('Voulez-vous supprimer les sociétés selectionnées ?')){
                        return null;
                    }
                    var ids_soc='del^';
                    ids_soc+=$('.del-soc:checked')
                            .map(function(){return $(this).val();})
                            .get().join('^');
                    $.ajax({
                        type:'POST',
                        url: 'scripts/script.php',
                        data:'op-soc='+ids_soc,
                        success:opOK
                    });
                }
                if($(this).val()==='activ'){
                    if(!confirm('Voulez-vous activer les sociétés selectionnées ?')){
                        return null;
                    }
                    var ids_soc='act^';
                    ids_soc+=$('.del-soc:checked')
                            .map(function(){return $(this).val();})
                            .get().join('^');
                    $.ajax({
                        type:'POST',
                        url: 'scripts/script.php',
                        data:'op-soc='+ids_soc,
                        success:opOK
                    });
                }
                if($(this).val()==='desact'){
                    if(!confirm('Voulez-vous desactiver les sociétés selectionnées ?')){
                        return null;
                    }
                    var ids_soc='desact^';
                    ids_soc+=$('.del-soc:checked')
                            .map(function(){return $(this).val();})
                            .get().join('^');
                    $.ajax({
                        type:'POST',
                        url: 'scripts/script.php',
                        data:'op-soc='+ids_soc,
                        success:opOK
                    });
                }
            }
            function opOK(rslt){
                
                var tab=rslt.split('^');
                if(tab.length>0){
                    for(var i=1;i<tab.length;i++){
                        if(tab[0]==='del'){
                            $('#tr-' + tab[i]).remove();
                        }
                        if(tab[0]==='act'){
                            $('#tr-' + tab[i]).attr('class', 'act');
                        }
                        if(tab[0]==='desact'){
                            $('#tr-' + tab[i]).attr('class','desact');
                        }
                    }
                }
                $('#default-opt').prop('selected',true);
            }
        });
        $('.close-mail').click(function(){ 
            $('#MyIg').html('');
            $('#default-opt').prop('selected',true);
        });
        
        //############### SCRIPT TRAITANT LA FENETRE ANNONCEURS/BASE INFOS ################
        //######################################################################
        $('#add-annonce').click(function(){
            var data=$('.annonce-form').map(function(){return $(this).val();}).get().join('^');
            var data_cont=$('.contact-form').map(function(){return $(this).val();}).get().join('^');

            var id_ann=$('#num-ann').val();
            var type=$(this).attr('name');
            //alert(data);
            $.ajax({
                type:'POST',
                url: 'scripts/script.php',
                data:'add-annonceur='+id_ann + '^' + type + '^' + data + '#' + data_cont,
                success:load_annonce
            });
        });
        $('.clic').click(function(){
            if($(this).is('checked')){
                $(this).val('TRUE');
            }else{
                $(this).val('FALSE');
            }
        });
        $('#del-annonce').click(function(){
            if(!confirm('Voulez-vous supprimer cet annonceur ?')){
                return null;
            }
            var id_ann=$('#num-ann').val();
            $.ajax({
                type:'POST',
                url: 'scripts/script.php',
                data:'del-annonceur='+id_ann,
                success:reponse_infos
            });
        });
        $('.ann-chkbx').click(function(){
            if($(this).is(':checked')){
                $(this).val('TRUE');
            }else{
                $(this).val('FALSE');
            }
        });
        $('.ch-type-infos').click(function(){
            var id_ann=$('#num-ann').val();
            var id=$(this).val();
            if(id_ann){
                $.ajax({
                    type:'POST',
                    url: 'scripts/script.php',
                    data:'ch-type-infos='+ id_ann + '^' +id,
                    success:reponse_infos
                });
            }
        });
        $('.abon-chck').click(function(){
            var id=$('#num-ann').val();
            $.ajax({
                type:'POST',
                url: 'scripts/script.php',
                data:'ch-abonnement='+ id,
                success:reponse_infos
            });
        });
        $('.chkbx-pays').click(function(){
             var ids=$(this).val();
             $.ajax({
                type:'POST',
                url: 'scripts/script.php',
                data:'ch-pays=' + ids,
                success:reponse_infos
            });
        });
        function load_annonce(rslt){
            //alert(rslt);
            $(location).attr('href',rslt);
        }
        
        /*--------------    code Appareil  ----------------- */
      
      
        $('#sel-mark').change(function(){
           var mark=$(this).val();
           if(mark==='autre'){
                $.ajax({
                    type:'POST',
                    url:'scripts/script.php',
                    data:'new-mark='+mark,
                    success:add_form
                });
           }else{
                $.ajax({
                    type:'POST',
                    url:'scripts/script.php',
                    data:'mark='+mark,
                    success:getModels
                });
           }
        });
        $('.mark-add').click(function(){
            var mark=$('.input-app').val();
            $.ajax({
                type:'POST',
                url: 'scripts/script.php',
                data:'mark-add='+ mark,
                success:add_form
            });
        });
        $('.mark-add-m').click(function(){
            var mark=$('.chbx-mark:checked').map(function(){return $(this).val();}).get().join('^');
            if(!mark){
                alert('Vous devez selectionner un fabricant !');
                return null;
            }
            var model=$('.input-app-m').val();
            $.ajax({
                type:'POST',
                url: 'scripts/script.php',
                data:'mark-add-m='+ mark + '^' + model,
                success:add_form
            });
        });
        $('.new-app').click(function(){
            $.ajax({
                type:'POST',
                url: 'scripts/script.php',
                data:'open-app='+$('#num-soc').val(),
                success:add_form
            });
        });
        $('#add-app').click(function(){
            if(!$('#sel-mark').val()){
               alert('Vous devez selectionner un fabricant !');
               return null;
            }
            if(!$('#sel-mod').val()){
               alert('Vous devez selectionner un model !');
               return null;
            }
            if(!$('#app-nom').val()){
               alert('Le nom de l\'appareil est obligatoire !');
               return null;
            }
            var data=$('#sel-mark').val() + '^' + $('#sel-mod').val() + '^' + $('#app-imat').val() + '^' + $('#app-nom').val();
            $.ajax({
                type:'POST',
                url: 'scripts/script.php',
                data:'add-app=' + data,
                success:add_form
            });
        });
        $('.del-app').click(function(){
           if(!confirm('Voulez-vous supprimer cet appareil ?')){
               return null;
           }
           var id=$(this).attr('value');
           $.ajax({
                type:'POST',
                url: 'scripts/script.php',
                data:'del-app=' + id,
                success:add_form
            });
        });
        $('#sel-mod').change(function(){
           var id=$(this).val();
            $.ajax({
                type:'POST',
                url: 'scripts/script.php',
                data:'sel-app=' + id,
                success:refreshapp
            });
        });
        $('.chbx-mark').click(function(){
            $('.chbx-mark').prop('checked',false);
            $(this).prop('checked',true);
            var id=$(this).val();
            $.ajax({
                type:'POST',
                url: 'scripts/script.php',
                data:'sel-model=' + id,
                success:refreshmodel
            });
        });
        $('.del-fab').click(function(){
           if(!confirm('Voulez-vous supprimer ce fabricant ?')){
               return null;
           }
           var id=$(this).attr('value');
           $.ajax({
                type:'POST',
                url: 'scripts/script.php',
                data:'del-fab=' + id,
                success:add_form
            });
        });
        $('.del-model').click(function(){
           if(!confirm('Voulez-vous supprimer ce modèle ?')){
               return null;
           }
           var id=$(this).attr('value');
           $.ajax({
                type:'POST',
                url: 'scripts/script.php',
                data:'del-model=' + id,
                success:add_form
            });
        });
        function refreshmodel(rslt){
            $('#list-model').html(rslt);
            load();
        }
        function getModels(res){
            var sel=$('#sel-mod');
            sel.html(res); 
        }
        function refreshapp(rest){
            $('#list-app').html(rest);
            load();
        }
        
        //############### SCRIPT POUR GESTION PIPECE ######################
        $('.sup-piece').click(function(){
            var id=$(this).attr('for');
            if(!confirm('Voulez-vous supprimer cette pièce de la commande ?')){
                return null;
            }
            $.ajax({
                type:'POST',
                url: 'scripts/script.php',
                data:'del-piece=' + id,
                success:reponse_infos
            });
        });
        $('.sup-vte').click(function(){
            var id=$(this).attr('for');
            if(!confirm('Voulez-vous supprimer ce vendeur ?')){
                return null;
            }
            $.ajax({
                type:'POST',
                url: 'scripts/script.php',
                data:'del-vte=' + id,
                success:reponse_infos
            });
        });
        $('.cmd-cond').click(function(){
            var id=$(this).attr('value');
            if(!id){
                return null;
            }
            $.ajax({
                type:'POST',
                url: 'scripts/script.php',
                data:'add-cond=' + id,
                success:reponse_infos
            });
        });
        $('.ref-piece').change(function(){
            var val=$(this).val();
            $.ajax({
                type:'POST',
                url: 'scripts/script.php',
                data:'load-piece=' + val,
                success:load_piece
            });
        });
        //############### SCRIPT POUR GESTION COMMANDE ######################
        $('.del-cmd').click(function(){
            if(!confirm('Voulez-vous supprimer cette commande ?')){
                return null;
            }
            var id=$(this).attr('id');
            $.ajax({
                type:'POST',
                url: 'scripts/script.php',
                data:'del-cmd=' + id,
                success:reponse_infos
            });
        });
        $('#updt-cmd').click(function(){
            var data=$('.form').map(function(){return $(this).val();}).get().join('^');
            var f=data.split('^');
            if(f[1]==='selectionnez'){
                alert('Une société acheteur est obligatoire !');
                return null;
            }
            if(!$('.pn-pce').val()){
                alert('Un PN_piece est obligatoires !');
                return null;
            }
            //alert(data);
            if(!$('.num-cmd').val()){
                
                //---- On verifie si la pièce rentrée xiste bien ---
                $.ajax({
                    type:'POST',
                    url: 'scripts/script.php',
                    data:'pce-exist=' + f[10],
                    success:add_cmd
                });
            }else{
                //---- On verifie si la pièce rentrée xiste bien ---
                $.ajax({
                    type:'POST',
                    url: 'scripts/script.php',
                    data:'pce-exist=' + f[12],
                    success:updt_cmd
                });
            }
            function add_cmd(rslt){
                //alert(data);
                if(rslt==='1'){
                    $.ajax({
                        type:'POST',
                        url: 'scripts/script.php',
                        data:'add-cmd=' + data,
                        success:load_annonce
                    });
                }else{
                    if(confirm(rslt)){
                        //alert(f[12]);
                        $.ajax({
                            type:'POST',
                            url: 'scripts/script.php',
                            data:'other-pce=' + f[10],
                            success:add_cmd
                        }); 
                    }
                }
            }
            function updt_cmd(rslt){
                if(rslt==='1'){
                    $.ajax({
                        type:'POST',
                        url: 'scripts/script.php',
                        data:'updt-cmd=' + data,
                        success:load_annonce
                    });
                }else{
                    if(confirm(rslt)){
                       $.ajax({
                            type:'POST',
                            url: 'scripts/script.php',
                            data:'other-pce=' + f[12],
                            success:updt_cmd
                        }); 
                    }
                }
            }
        });
        $('#add-gp').click(function(){
            var data=$('.form').map(function(){return $(this).val();}).get().join('^');
            var f=data.split('^');
            if(!$('.num-cmd').val()){
                if(f[1]==='selectionnez'){
                    return null;
                }
                $.ajax({
                    type:'POST',
                    url: 'scripts/script.php',
                    data:'add-gp=' + data,
                    success:load_annonce
                });
            }else{
                $.ajax({
                    type:'POST',
                    url: 'scripts/script.php',
                    data:'updt-gp=' + data,
                    success:reponse_infos
                });
            }
        });
        $('.cmd-gp').click(function(){
            var id=$(this).attr('value');
            if(!id){
                return null;
            }
            $.ajax({
                type:'POST',
                url: 'scripts/script.php',
                data:'add-type-doc=' + id,
                success:reponse_infos
            });
        });
        $('.entr-cmd').change(function(){
            var ids=$(this).val();
            $(location).attr('href','?rub=liste&s-rub=fiche-par-societe&soc=' + ids);
        });
        $('.add-note').click(function(){
            var id=$(this).attr('value');
            $.ajax({
                type:'POST',
                url: 'scripts/script.php',
                data:'new-note=' + id,
                success:add_form
            });
        });
        $('.new-note').click(function(){
            var form=$('.vte-note').map(function(){return $(this).val();}).get().join('^');
            //alert(form);
            $.ajax({
                type:'POST',
                url: 'scripts/script.php',
                data:'add-note=' + form,
                success:reponse_infos
            });
        });
        $('.view-propose').click(function(){
            var id=$(this).attr('value');
            $.ajax({
                type:'POST',
                url: 'scripts/script.php',
                data:'view-propose=' + id,
                success:add_form
            });
        });
        function load_cmd(rslt){
            //alert(rslt)
        }
        //----- Quand on selectionne une société dans l'ajout de piece ---
        //---- On charge les appareil liés au fabricant concerné ---------
        /*
        $('.load-app').change(function(){
            var id=$(this).val();
            $.ajax({
                type:'POST',
                url:'scripts/script.php',
                data:'load-app=' + id,
                success:load_app
            });
        });
        */
        //--- Quand on effectue des modification -------
        $('.updt-img').click(function(){
            var id=$(this).attr('value');
            var idx=$(this).attr('id');
            var data=id + '^' + $('.piece-form-'+idx).map(function(){ return $(this).val();}).get().join('^');
            $.ajax({
                type:'POST',
                url:'scripts/script.php',
                data:'updt-piece=' + data,
                success:reponse_infos
            });
        });
        //---- Quand on clique sur Document ----
        $('.doc').click(function(){
            var idf=$(this).attr('value')+'^'+$('.num-cmd').val();
            var url=$(this).attr('name');
            //alert(url)
            $.ajax({
                type:'POST',
                url:'scripts/script.php',
                data:'load-docs=' + idf + '^' + url,
                success:add_form
            });
        });
        $('.add-doc').click(function(){
            var form=$('#page-src');
            form.attr('action','scripts/script.php');
            //var nomDoc=$('#desc-doc').val();
            //var srcDoc=$('#src-doc').val();
            //var frs=$('#num-frs').val();
            $.ajax({
                type:form.attr('method'),
                url: form.attr('action'),
                data:form.serialize(),
                success:refreshweb
            });
        });
        $('.del-doc').click(function(){
            if(!confirm('Voulez-vous supprimer ce document ?')){
                return null;
            }
            var ids=$(this).attr('value');
            $.ajax({
                type:'POST',
                url:'scripts/script.php',
                data:'del-doc=' + ids,
                success:refreshweb
            });
        });
        //---- Quand on clique sur Photo -----
        $('.photo').click(function(){
            var idf=$(this).attr('value')+'^'+$('.num-cmd').val();
            $.ajax({
                type:'POST',
                url:'scripts/script.php',
                data:'load-imgs=' + idf,
                success:add_form
            });
        });
        $('.add-img').click(function(){
            var form=$('#page-src');
            form.attr('action','scripts/script.php');
            //var nomDoc=$('#desc-doc').val();
            //var srcDoc=$('#src-doc').val();
            //var frs=$('#num-frs').val();
            $.ajax({
                type:form.attr('method'),
                url: form.attr('action'),
                data:form.serialize(),
                success:refreshweb
            });
        });
        $('.del-img').click(function(){
            if(!confirm('Voulez-vous supprimer cette image ?')){
                return null;
            }
            var ids=$(this).attr('value');
            $.ajax({
                type:'POST',
                url:'scripts/script.php',
                data:'del-img=' + ids,
                success:refreshweb
            });
        });
        $('.add-plus').click(function(){
            var id=$(this).attr('name');
            var num_soc=$('.id-pce-' + id).val();
            //alert(num_soc);
            $.ajax({
                type:'POST',
                url:'scripts/script.php',
                data:'plus-form=' + num_soc,
                success:add_form
            });
        });
        $('.add-more').click(function(){
            var data=$('.id-frs').val() + '^' + $('.src-doc').map(function(){return $(this).val();}).get().join('^');
            //alert(data);
            $.ajax({
                type:'POST',
                url:'scripts/script.php',
                data:'add-more=' + data,
                success:reponse_infos
            });
        });
        $('.set-updt').change(function(){
            var name=$(this).attr('name');
            var val=$(this).val();
            var data = name + '^' + val;
            //alert(data);
            $.ajax({
                type:'POST',
                url:'scripts/script.php',
                data:'updt-vte=' + data,
                success:reponse_infos
            });
        });
        $('.set-updt-pce').change(function(){
            var name=$(this).attr('name');
            var val=$(this).val();
            var data = name + '^' + val;
            //alert(data)
            $.ajax({
                type:'POST',
                url:'scripts/script.php',
                data:'updt-pce-cell=' + data,
                success:reponse_infos
            });
        });
        $('.pn-comment').change(function(){
            var val=$(this).val();
            var id=$(this).attr('name');
            $.ajax({
                type:'POST',
                url:'scripts/script.php',
                data:'pn-comment=' + id + '^' + val,
                success:reponse_infos
            });
        });
        function load_app(rslt){
            //alert(rslt)
            if(rslt!==''){
                $('.sel-app-load').html(rslt);
            }
        }
        function load_piece(rslt){
            var str=rslt.split('^');
            //alert(str[13])
            if(str[0]!==''){
                $('.f-ref-piece').val(str[0]);
                $('.f-pn-piece').val(str[1]);
                $('.f-pn-alt-piece').val(str[2]);
                $('.f-ot-piece').val(str[3]);
                $('.f-sel-type').val(str[4]);
                if(str[5]){
                    $('.f-sel-soc').val(str[5]);
                    $('.f-sel-cond').val(str[6]);
                    $('.f-sel-trans').val(str[7]);
                    $('.f-quant-piece').val(str[8]);
                    $('.f-prix-piece').val(str[9]);
                    $('.f-maj-piece').val(str[10]);
                }
                if(str[11]){
                    $('.f-cont').val(str[11]);
                    $('.f-mail').val(str[12]);  
                }
                if(str[13]){
                    $('.f-sel-app').val(str[13]);
                    //$('.f-sel-fab').val(str[14]);
                }
            }
        }
        
        function reponse_infos(rslt){
            //alert(rslt);
            window.location.reload();
        }
        
    });
}

//################## SCRIPT POUR LE MOTEUR DE RECHERCHES #####################
//############################################################################

function go_search(id){
    var val=$('#'+id).val();
    $.ajax({
        type:'POST',
        url: 'scripts/script.php',
        data:'search=' + val + '^' + $('#' + id).attr('name'),
        success:refreshdata
    });
}
function refreshdata(rslt){
    $('#ann-list').html(rslt);
}
function find_fraude(val){
    $.ajax({
        type:'POST',
        url: 'scripts/script.php',
        data:'search-fraude=' + val,
        success:refreshfraude
    });
}
function refreshfraude(rslt){
    //alert(rslt);
    $('#list-fraude').html(rslt);
}
function find_stock(val){
    $.ajax({
        type:'POST',
        url: 'scripts/script.php',
        data:'search-stock=' + val,
        success:refreshfraude
    });
}
function find_board(val){
    $.ajax({
        type:'POST',
        url: 'scripts/script.php',
        data:'search-board=' + val,
        success:refreshfraude
    });
}
function find_paperboard(val){
    $.ajax({
        type:'POST',
        url: 'scripts/script.php',
        data:'search-pn=' + val,
        success:refreshfraude
    });
}
function find_vte(val){
    var vte=$('.num-vte').attr('value');
    //alert(vte)
    $.ajax({
        type:'POST',
        url: 'scripts/script.php',
        data:'search-vte=' + vte + '^' + val,
        success:refreshfraude
    });
}
function refreshfraude(rslt){
    //alert(rslt);
    $('#list-stock').html(rslt);
}

//################# SCRIPT TRAITANT LA SAISIE DES PCES ET VENDEUR DANS FICHE GRPE ----//

function don_saisie(ids){
    var val=ids.split('^');
   
    /*** création du formulaire de saisie pour pièce ***/
    var pce='';
    if(!val[1]){
        $.ajax({
            type:'POST',
            url: 'scripts/script.php',
            data:'gen-form=' + ids,
            success:(function(rslt){$('#list-stock').append(rslt);})
        });
        /** on recupère les valeur saisi et on sauve**/
        var data=$('.pce').map(function(){return $(this).val();}).get().join('^');
        if(data){
            var id=$('.pce').attr('id');
            $.ajax({
                type:'POST',
                url: 'scripts/script.php',
                data:'new-pce=' + id + '#' + data,
                success:refresh_page
            });
        }
    }else{
        $.ajax({
            type:'POST',
            url: 'scripts/script.php',
            data:'gen-form=' + ids,
            success:(function(rslt){$('.new-vte-' + val[1]).append(rslt);})
        });
        /** on recupère les valeur saisi et on sauve**/
        var data=$('.vte').map(function(){return $(this).val();}).get().join('^');
        if(data){
            var id=$('.vte').attr('id');
            $.ajax({
                type:'POST',
                url: 'scripts/script.php',
                data:'new-pce=' + id + '#' + data,
                success:refresh_page
            });
        }
    }
}
function refresh_page(rslt){
    //alert(rslt);
    window.location.reload();
}
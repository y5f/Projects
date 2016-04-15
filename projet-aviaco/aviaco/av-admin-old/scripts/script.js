
//----- La rubrique sur laquelle on vient de cliquer ---
var current_rub;

//------ VARIABLES CONTENANT LES LETTRE AVEC ACCENT ET SANS ACCENT ---//
var pattern_accent = {'é':'e', 'è':'e', 'ê':'e', 'ë':'e', 'ç':'c', 'à':'a', 'â':'a', 'ä':'a', 'î':'i', 'ï':'i', 'ù':'u', 'ô':'o', 'ó':'o', 'ö':'o'};

load();
function load(){$(document).ready(function(){
        
    var idx_control=true;
    
    //######### GESTION DES RUBRIQUES PRINCIPALES ###//
    /*
    //---- Quand la souris survle une rubrique ---//
    $('.rub').mouseover(function(){
        $(this).css({
            'cursor':'pointer'
        });
    });
   
    //--- Quand on clique sur une rubrique ---//
    $('.rub').click(function(){
        var id=$(this).attr('name');
        $('#'+id).slideToggle(200);
        
    });
    */
    //########################################################//
    //####### CE BLOC DE CODE GERE LA RUBRIQUE CATEGORIE #####//
    //########################################################//
    $('.item').click(function(){
        var nom=$(this).attr('name');
        //alert(nom)
        var data='cat='+nom;
        if(idx_control){
            $.ajax({
                type:'POST',
                url:'scripts/script.php',
                data:data,
                success:refreshdata
            });
            idx_control=false;
        }
    });
    
    //--- Script qui recupere lesvaleur à rajouter dans la base --//
    function add_cat(form){
        var tab='';
        $('.form').each(function(){
            tab+=$(this).val()+'#';
        });
        //alert(tab)
        $.ajax({
            type:'POST',
            url:'scripts/script.php',
            data:form+'='+tab,
            success:isOK
        });
    }
    
    function upde_cat(data){
        var tab='';
        $('.form-mod').each(function(){
            tab+=$(this).val()+'#';
        });
        //alert(tab);
        
        $.ajax({
            type:'POST',
            url:'scripts/script.php',
            data:data + '=' + tab,
            success:isOK
        });
        
    }
    $('#new-valider').click(function(){
        if(idx_control){
            add_cat('form');
            idx_control=false;
        }
        
    });
    $('#prop-mod').click(function(){
        if(idx_control){
            upde_cat('form-mod');
            idx_control=false;
        }
    });
    $('#prop-sup').click(function(){
        if(idx_control){
            if(!confirm('Voulez-vous vraimment supprimer cette catégorie ?')){
                return null;
            }
            upde_cat('form-sup');
            idx_control=false;
        }
    });
    
    $('.el').click(function(){
        //alert($(this).attr('class').split(' ')[1]);
        current_rub=this;
        //showForm();
    });
    //--- Quand on saisit la categ, on reconstruit le lien --//
    $('#cat').change(function(){
        var chaine=$(this).val();
        var url=str_no_accent(chaine);
        $('#n-url').val(url);
    });
    
    function showresult(resultat){
        //alert(resultat);
        $('.s-bloc').html(resultat);
        load();
    }
    
    function refreshdata(resultat){
        //alert(resultat);
        
        var tab=resultat.split('#');
        $('#parent').val(tab[1]);
        $('#desc').val(tab[2]);
        $('#hidden').val(tab[0]);
        $('#url').val(tab[3]);
        $('#ord').val(tab[4]);
        $('#com').html(tab[5]);
        
        //-- On rempli le champsparent dans new categ --//
        var str='';
        
        str+='<option>'+tab[2]+'</option>';
        str+='<option>aucun</option>';
        $('#n-parent').html(str);
        
        load();
    }
    function showForm(){
       //alert(current_rub);
       $.ajax({
            type:'POST',
            url:'scripts/script.php',
            data:'rub='+$(current_rub).attr('class').split(' ')[1],
            success:showresult
        }); 
    }
    
    //########################################################//
    //####### CE BLOC DE CODE GERE LA RUBRIQUE MENU ##########//
    //########################################################//
    $('.add').click(function(){
        checked_cat('cat');
    });
    $('.ad-m').click(function(){
        checked_menu('ad-m');
    });
    $('.cbx').click(function(){
        if(idx_control){
            $('.cbx').prop('checked',false);
            if($(this).prop('checked')){
                $(this).prop('checked',false);
            }else{
                $(this).prop('checked',true);
            }
        }
        $('.ajour').css({
            'display':'none'
        });
        $('.new-menu').css({
            'display':'block'
        });
    });
    $('#reset-menu').click(function(){
        //$('#parent').val('');
        $('#desc').val('');
        $('#hidden').val('');
        $('#url').val('');
        $('#ord').val('');
        $('#com').html('');
    });
    $('#add-menu').click(function(){
        if(idx_control){
            add_cat('menu');
        }
    });
    $('#menu-mod').click(function(){
        if(idx_control){
            upde_cat('menu-mod');
        }
    });
    function checked_cat(tab){
        if(idx_control){
            $('.cbx').each(function(){
                if($(this).prop('checked')){
                    //alert($(this).prop('value'));
                    $.ajax({
                        type:'POST',
                        url:'scripts/script.php',
                        data:tab+'=' + $(this).prop('value'),
                        success:refreshdata
                    });
                }
            });
        }
    }
    function checked_menu(tab){
        if(idx_control){
            $('.cbx').each(function(){
                if($(this).prop('checked')){
                    //alert($(this).prop('value'));
                    $.ajax({
                        type:'POST',
                        url:'scripts/script.php',
                        data:tab+'=' + $(this).prop('value'),
                        success:refreshed
                    });
                }
            });
        }
    }
    function refreshed(data){
        var tab=data.split('#');
        //alert(data);
        //-- On rempli le champsparent dans new categ --//
        var str='';
        
        str+='<option>'+tab[2]+'</option>';
        str+='<option>aucun</option>';
        $('#parent').html(str);
        
        load();
    }
    
    $('.it').click(function(){
        var nom=$(this).attr('name');
        //alert(nom)
        var data='ad-m='+nom;
        if(idx_control){
            $.ajax({
                type:'POST',
                url:'scripts/script.php',
                data:data,
                success:refreshdata
            });
            idx_control=false;
        }
        $('.ajour').css({
            'display':'block'
        });
        $('.new-menu').css({
            'display':'none'
        });
    });
    $('.del-menu').click(function(){
        if(!confirm('Voulez-vous supprimer ce menu ?')){
            return null;
        }
        var id=$(this).attr('for')+'#'+$(this).attr('id');
        if(idx_control){
            del_menu(id);
        }
    });
    function del_menu(id){
        $.ajax({
            type:'POST',
            url:'scripts/script.php',
            data:'menu-sup=' + id,
            success:isOK
        });
    }
    $('#desc').change(function(){
        var chaine=$(this).val();
        var url=str_no_accent(chaine);
        $('#url').val(url);
    });
    
    //########## FONCTION TRAITANT LE FORMULAIRE USER ###############
    /////////////////////////////////////////////////////////////////
    $('#user-reset').click(function(){
        //alert('ok');
        $('#user-name').val('');
        $('#user-pren').val('');
        $('#user-adr').val('');
        $('#user-post').val('');
        $('#user-fonc').val('');
        $('#user-tel').val('');
    });
    $('#user-add').click(function(){
        //alert('ok');
        var name=$('#user-name-n').val();
        var prenom=$('#user-pren-n').val();
        var adr=$('#user-adr-n').val();
        var cp=$('#user-post-n').val();
        var fon=$('#user-fonc-n').val();
        var acces=$('#user-acc-n').val();
        var tel=$('#user-tel-n').val();
        var pass=$('#user-pass-n').val();
        var email=$('#user-mail-n').val();
        //alert(fon);
        if(name !=='' && prenom!=='' && cp!=='' && tel!==''){
            var data=name+'#'+prenom+'#'+adr+'#'+cp+'#'+fon+'#'+acces+'#'+tel+'#'+email+'#'+pass;
            $.ajax({
                type:'POST',
                url:'scripts/script.php',
                data:'user-add='+data,
                success:isOK
            });
        }else{
            alert('les champs Nom, prénom, code postal et téléphone sont obligatoires !');
        }
        
    });
    $('#user-mod').click(function(){
        //alert($('#user-name').val());
        var id=$('#user-id').val();
        var name=$('#user-name').val();
        var prenom=$('#user-pren').val();
        var adr=$('#user-adr').val();
        var cp=$('#user-post').val();
        var fon=$('#user-fonc').val();
        var etat=$('#user-etat').val();
        var tel=$('#user-tel').val();
        var email=$('#user-mail').val();
        var pass=$('#user-pass').val();
        var acces=$('#user-acc').val();
              
        if(name !=='' && prenom!=='' && cp!=='' && tel!==''){
            
            var data=id+'#'+name+'#'+prenom+'#'+adr+'#'+cp+'#'+fon+'#'+etat+'#'+tel+'#'+email+'#'+pass+'#'+acces;
            
            $.ajax({
                type:'POST',
                url:'scripts/script.php',
                data:'user-mod='+data,
                success:isOK
            });
        }else{
            alert('les champs Nom, prénom, code postal et téléphone sont obligatoires !');
        }
        
    });
    
    $('.user-select').click(function(){
        var id=$(this).attr('id');
        //alert(id);
        $.ajax({
            type:'POST',
            url:'scripts/script.php',
            data:'user-select='+id,
            success:userrefresh
        });
    });
    $('#user-sup').click(function(){
        if(!confirm('Voulez-vous supprimer cet utilisateur ?')){
            return null;
        }
        var id=$('#user-id').val();
        $.ajax({
            type:'POST',
            url:'scripts/script.php',
            data:'user-delete='+id,
            success:isOK
        });
    });
    function userrefresh(rslt){
        str=rslt.split('#');
        //alert($('#user-name').val());
        $('#user-id').val(str[0]);
        $('#user-name').val(str[1]);
        $('#user-pren').val(str[2]);
        $('#user-adr').val(str[3]);
        $('#user-post').val(str[4]);
        $('#user-fonc').val(str[5]);
        $('#user-etat').val(str[6]);
        $('#user-tel').val(str[7]);
        $('#user-mail').val(str[8]);
        $('#user-pass').val(str[9]);
        $('#user-acc').val(str[10]);
        
    }
    
    //########## FONCTION TRAITANT LES PUBLICATIONS #################
    /////////////////////////////////////////////////////////////////
    $('.item-pub').click(function(){
        var id=$(this).attr('class').split(' ')[1];
        $.ajax({
            type:'POST',
            url:'scripts/script.php',
            data:'pub-art='+id,
            success:refreshart
        });
    });
    function refreshart(rslt){
        //alert(rslt);
        var art=rslt.split('#');
        $('#numart').val(art[0]);
        $('#titreart').val(art[1]);
        $('#auteurart').val(art[2]);
        
    }
    $('#mod-pub').click(function(){
        var data=$('#numart').val()+'#'+$('#titreart').val()+'#'+$('#auteurart').val();
        $.ajax({
            type:'POST',
            url:'scripts/script.php',
            data:'mod-pub='+data,
            success:isOK
        });
    });
    $('#pub-pub').click(function(){
        if(!$('#date-pub').val()){
            alert('Veillez choisir une date de publication');
            return null;
        }
        var data=$('#numart').val()+'#'+$('#date-pub').val()+'#'+$('#etat-pub').val()+'#'+$('#slid-pub').val();
        $.ajax({
            type:'POST',
            url:'scripts/script.php',
            data:'pub-pub='+data,
            success:isOK
        });
    });
    $('.item-act').click(function(){
        var id=$(this).attr('class').split(' ')[1];
        //alert(id);
        $.ajax({
            type:'POST',
            url:'scripts/script.php',
            data:'pub-select='+id,
            success:refreshpub
        });
    });
    function refreshpub(rslt){
        //alert(rslt);
        var str=rslt.split('#');
        
        $('#num-pub').val(str[0]);
        $('#dte-edit').val(str[1]);
        $('#dte-pub').val(str[2]);
        $('#aut-pub').val(str[3]);
        $('#e-pub').val(str[4]);
        $('#s-pub').val(str[5]);
        //$('#dte-edit').datepicker({ minDate: new Date($.datepicker.parseDate('d/m/Y',str[1]))});
        
    }
    $('#dep-valider').click(function(){
        if(!$('#dte-edit').val() || !$('#dte-pub').val()){
            alert('Les dates ne peuvent pas $etre vide');
            return null;
        }
        var data=$('#num-pub').val()+'#'+$('#dte-edit').val()+'#'+$('#dte-pub').val()+'#'+$('#aut-pub').val()+'#'+$('#e-pub').val()+'#'+$('#s-pub').val();
        $.ajax({
            type:'POST',
            url:'scripts/script.php',
            data:'dep-valider='+data,
            success:isOK
        });
    });
    
    //########## FONCTION TRAITEMENT LES ARTICLES ###################
    /////////////////////////////////////////////////////////////////
    $('.art-del').click(function(){
        if(!confirm('Voulez-vous supprimer cet article ?')){
            return null;
        }
        var id=$(this).attr('class').split(' ')[1];
        $.ajax({
            type:'POST',
            url:'scripts/script.php',
            data:'art-del='+id,
            success:isOK
        });
    });
    $('#categ').change(function(){
        //alert($(this).val());
        var cat=$(this).val();
        $.ajax({
            type:'POST',
            url:'scripts/script.php',
            data:'edit-cat='+cat,
            success:refreshcat
        });
    });
    function refreshcat(rslt){
        var str=rslt.split('#');
        $('#s-categ').html('');
        for(var i=0;i<str.length-1;i++){
            var item=str[i].split('&');
            $('#s-categ').append('<option value='+ item[1]+'>'+item[0]+'</option>');
        }
    }
    
    $('#edit-form').on('submit',function(){
       
        if($('#categ').val()==='aucun' || $('#s-categ')==='aucun'){
            alert('Vous devez choisir une catégorie et une sous-catégorie');
            return null;
        }
        var $this=$('#edit-form');
        $this.attr('action','scripts/script.php');
        $.ajax({
            type:$this.attr('method'),
            url:'scripts/script.php',
            data:$this.serialize(),
            success:isOK
        });
    });
    
    $('#titre').change(function(){
        var url=str_no_accent($(this).val());
        //alert(url);
        $('#url').val(url);
    });
    
    //###############################################################
    //########### SCRIPT TRAITANT LA FENETRE LOGIN ##################
    
    $('#usr-open').click(function(){
        $('#usr-bloc').slideToggle(300);
    });
    //
    //########## FONCTION TRAITEMENT CHAINE DE CARACTERES ###########
    /////////////////////////////////////////////////////////////////
    function str_no_accent(str){
        var chaine='';
        for(var i=0;i<str.length;i++){
            var replace_char=pattern_accent[str[i]];
            if(replace_char){
              chaine=str.replace(str[i],replace_char);
              str=chaine;
            }else{
                chaine=str;
            }
        }
        //alert(chaine);
        return space_replace(chaine);
    }
    function space_replace(str){
        var chaine='';
        for(var i=0;i<str.length;i++){
            if(str.indexOf(' ')!=='-1'){
                chaine=str.replace(' ','-');
                str=chaine;
            }
            if(str.indexOf('\'')!==-1){
                chaine=str.replace('\'','-');
                str=chaine;
            }
        }
        return chaine.toLowerCase();
    }
    function isOK(rslt){
        //alert(rslt);
        window.location.reload();
        //showForm();
    }
});

}

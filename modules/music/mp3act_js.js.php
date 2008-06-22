        window.onload=function(){ init(); };

        function init(){
            setPageTitle();
            x_viewPlaylist(viewPlaylist_cb);
            x_playlistInfo(plinfo_cb);
            setPLTitle();
            setCurrentPage();
            updateBox(page,0);
        }
        function empty_cb(new_data){

        }

        function setPageNav(){
            //document.getElementById("breadcrumb").innerHTML = prevpage;
        }

        function switchPage(newpage){
            prevpage = page;
            page = newpage;

            updateBox(page,0);
            setPageTitle();
            setCurrentPage();
            //setPageNav();
        }

        function setPLTitle(){
            document.getElementById("pl_title").innerHTML = " <?php echo t("Playlist"); ?> ";
        }

        function viewPlaylist_cb(new_data){
            document.getElementById("playlist").innerHTML = new_data;
        }

        function setCurrentPage(){
            var x = document.getElementById('nav');
            var y = x.getElementsByTagName('a');
            for (var i=0;i < y.length;i++){
                    y[i].removeAttribute("class");
                    if(y[i].id == page)
                        y[i].setAttribute('class','c');
                }
        }

        function getDropDown(type,id){
            x_getDropDown(type,id,getDropDown_cb);
        }

        function getDropDown_cb(new_data){
            ul = document.getElementById("browse_ul");
            ul.innerHTML = new_data;
            ul.style.display = 'block';
        }

        function closeDropDown(){
            ul = document.getElementById("browse_ul");
            ul.style.display = 'none';
            ul.innerHTML = '';
        }

    function savePL_cb(data){
                var save_form = '<h2><?php echo t('Save/Rename Playlist'); ?></h2>' +
          '<form onsubmit="return savePL(\'save\',this)" method="get" action="">' +
          '<strong><?php echo t('Playlist Name'); ?></strong><br/>' +
          '<?php echo t('Enter a new name for your playlist'); ?><br><br>' +
          '<input type="text" name="save_pl_name" id="save_pl_name" size="25" />' +
          '<input style="left: 350px; position: absolute;" type="submit" value="<?php echo t('Save/Rename'); ?>" />' +
          '</form>' +
          '<br><hr><br>' +
          '<input style="left: 350px; position: absolute;" type="button"' +
          ' onclick="savePL(\'close\',0); return false;" value="<?php echo t('Cancel'); ?>" />';
            document.getElementById("box_extra").innerHTML = save_form;
                document.getElementById("box_extra").style.display = 'block';
        }

    function savePL(type,data){
        if(type=='open'){
          savePL_cb(data);
          return false;
        }
            else if(type=='save'){
                var pl_name = data.save_pl_name.value;
                x_savePlaylist(pl_name,0,save_Playlist_cb);
          x_playlistInfo(plinfo_cb);

                return false;
            }
            else if(type=='close')
                document.getElementById("box_extra").style.display = 'none';
        }

        function save_Playlist_cb(new_data){
            box = document.getElementById("box_extra");
            box.innerHTML = new_data;
            setTimeout("box.style.display='none'","1250");
        }

        function movePLItem(direction,item){
                var y;
                var temp;
        var pos = 0;
          temp = item;
        while (temp.previousSibling)
        {
          pos++;
          temp = temp.previousSibling;
        }

        if(direction == "up")
                y = item.previousSibling;
            else if(direction == "down")
                    y = item.nextSibling;

                if(y && y.nodeName == 'LI'){
                pl_move(pos, pos + ("up" == direction ? -1 : 1));

                var temp = y.innerHTML;
                y.innerHTML = item.innerHTML;
                item.innerHTML = temp;
                Fat.fade_element(y.id,null,900,'#ffcc99','#f3f3f3');
            }
        }

        function setBgcolor(id, c)
            {
                if(id != ('pl'+nowplaying)){
                var o = document.getElementById(id);
                o.style.backgroundColor = c;
                }
            }

            function setPageTitle(){
                var pages= new Array()
                pages["browse"]="<?php echo t("Browse Music"); ?> ";
                pages["search"]="<?php echo t("Search Music"); ?> ";
                pages["random"]="<?php echo t("Create a Random Mix"); ?> ";
                pages["playlists"]="<?php echo t("Load a Saved Playlist"); ?> ";
                pages["stats"]="<?php echo t("Server Statistics"); ?> ";
                document.getElementById("pagetitle").innerHTML = pages[page];

            }

            function getRandItems(type){
              //document.getElementById("breadcrumb").innerHTML = '';
              document.getElementById("rand_items").innerHTML = '';
                x_getRandItems(type,getRandItems_cb);
            }

            function getRandItems_cb(new_data){
                document.getElementById("rand_items").innerHTML = new_data;
            }

            function updateBox_cb(new_data){
                document.getElementById("info").innerHTML = new_data;
                document.getElementById("loading").style.display = 'none';

                if(clearbc==1)
                    breadcrumb();
                clearbc = 1;

            }

            function updateBox(type,itemid){
                document.getElementById("loading").style.display = 'block';
                x_musicLookup(type,itemid,updateBox_cb);

                if(type == 'genre' || type == 'letter'){
                    bc_parenttype = '';
                    bc_parentitem = '';
                }
                else if(type == 'album' || (type == 'artist' && bc_parenttype != '')){
                    if(bc_childtype == 'all'){
                        bc_parenttype = bc_childtype;
                        bc_parentitem = bc_childitem;
                    }
                }
                else if(type == 'browse' || type == 'search' || type == 'about' || type == 'prefs' || type == 'random' || type == 'admin' || type == 'playlists' || type == 'stats'){

                    bc_parenttype = '';
                    bc_parentitem = '';
                    itemid='';
                    type='';
                }
                else{
                    bc_parenttype = bc_childtype;
                    bc_parentitem = bc_childitem;
                }

                bc_childitem = itemid;
                bc_childtype = type;

            }

            function deletePlaylist(id){
                if(confirm("<?php echo t('Are you sure you want to DELETE THIS SAVED PLAYLIST?'); ?>")){
                    x_deletePlaylist(id,deletePlaylist_cb);
                }
            }

            function deletePlaylist_cb(new_data){
                // reload saved PL page
                clearbc = 0;
                x_musicLookup('playlists',0,updateBox_cb);
                setMsgText("<?php echo t('Saved Playlist Successfully Deleted'); ?>");
        // Also reload the playlist if we've deleted the active playlist!
        if (new_data){
          x_viewPlaylist(viewPlaylist_cb);
          x_playlistInfo(plinfo_cb);
        }
            }

            function plrem(item){
        var temp = item;
        var pos = 0;
        while (temp.previousSibling)
        {
          pos++;
          temp = temp.previousSibling;
        }

                x_playlist_rem(pos,plrem_cb);
            }

            function plrem_cb(rem){
                p = document.getElementById("playlist");
                d_nested = p.childNodes[rem];
                throwaway_node = p.removeChild(d_nested);
                x_playlistInfo(plinfo_cb);
            }

            function pladd(type,id){
                x_playlist_add(type,id,pladd_cb);
            }

            function pladd_cb(new_data){

                if(new_data[0] == 1){
                    x_viewPlaylist(viewPlaylist_cb);
                x_playlistInfo(plinfo_cb);
                }
                else if (new_data[0] == 2){
                    alert(new_data[1]);
                }
                else{
                    document.getElementById("playlist").innerHTML += new_data[0];

                    for(var i=2; i < new_data[1]+2; i++){
                        Fat.fade_element(new_data[i],null,1400,'#B4EAA2','#f3f3f3');
                    }
                    x_playlistInfo(plinfo_cb);
                }
            }

            function pl_move(item1,item2){
                x_playlist_move(item1,item2,pl_move_cb);
            }

            function pl_move_cb(){
                    // do nothing
            }

            function plclear(){
                x_clearPlaylist(plinfo_cb);
                document.getElementById("playlist").innerHTML = "";
            }

            function plinfo_cb(new_data){
                document.getElementById("pl_info").innerHTML = new_data;
            }

            function breadcrumb(){
                    x_buildBreadcrumb(page,bc_parenttype,bc_parentitem,bc_childtype,bc_childitem,breadcrumb_cb);
            }

            function breadcrumb_cb(new_data){
                //if(new_data!="")
                    document.getElementById("breadcrumb").innerHTML = new_data;
            }

            function play(type,id){
                    document.getElementById('hidden').src = null;
                    document.getElementById("hidden").src = "<?php echo stream_url(); ?>mp3act_hidden.php?type="+type+"&id="+id;
            }

            function randAdd(data){
                var type = data.random_type.value;
                if(type == ""){
                    setMsgText("You must choose a random type");
                    return false;
                }
                var num=0;
                num = data.random_count.value;
                var items ='';
                if(type != 'all'){
                    for(var i=0;i<data.random_items.options.length;i++){
                        if(data.random_items.options[i].selected == true)
                         items += ',' + data.random_items.options[i].value;
                    }

                    if(items == ""){
                      setMsgText("You must choose at least one random item");
                      return false;
                    }
                    items = items.substring(1);
                }
                if(data.rating.value == 'all'){
                    x_randAdd(type,num,items,randadd_cb);
                }
                else{
                    var filter = data.rating.value + ' ' + data.rating_value.value;
                    x_randAdd(type,num,items,filter,randadd_cb);
                }

                return false;

            }

            function randadd_cb(new_data){
                x_viewPlaylist(viewPlaylist_cb);
                    x_playlistInfo(plinfo_cb);
            }

            function play_cb(new_data){
                //refresh();
            }

            function setMsgText(text){
                    document.getElementById("breadcrumb").innerHTML = "<span class='error'>"+text+"</span>";
                    Fat.fade_element('breadcrumb',null,2000,'#F5C2C2','#ffffff');
            }

            function searchMusic(form){
                if(form.searchbox.value == '' || form.searchbox.value == '[<?php echo t("enter your search terms"); ?>]'){
                    setMsgText("You Must Enter Something to Search For");
                }
                else{
                    document.getElementById("breadcrumb").innerHTML = "";
                    x_searchMusic(form.searchbox.value,form.search_options.value,updateBox_cb);
                }
                return false;
            }

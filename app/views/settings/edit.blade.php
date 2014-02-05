<div class="row">
    <div class="edit_form col-sm-offset-1 col-sm-10 col-xs-12">
      <form action="http://ensmall.net/dev/haik_md/index.php" method="post" style="margin-bottom:0px;" id="edit_form_main">
    
        <input type="hidden" name="cmd" value="edit">
        <input type="hidden" name="page" value="">
        <input type="hidden" name="digest" value="">
        <input type="hidden" name="refer" value="">
        <input type="hidden" name="template_name" value="content">
        
        <input type="text" name="title" value="" placeholder="ページタイトル" class="col-sm-12 " tabindex="1">
      
      <div class="btn-toolbar">
        <div class="btn-group">
          <a href="http://toiee.jp/haik/help/index.php?StartGuide" id="haik_edit_manual_link" class="btn btn-default btn-sm" target="_blank">?</a>
        </div>
      </div>
      
      <div id="orgm_toolbox"></div>
      
      <textarea name="msg" id="msg" rows="20" cols="80" placeholder="クリックして文章を入力してください。" tabindex="2" data-exnote="onready" class="col-sm-12"></textarea>
   
      <br>
      <div class="edit_buttons" style="float: left; display: none;">
        <input type="submit" name="preview" value="プレビュー" tabindex="4" class="btn btn-info">
        <input type="submit" name="write" value="公開" tabindex="5" class="btn btn-primary">
        <input type="submit" name="cancel" value="破棄" tabindex="6" class="btn btn-default">
        
        <label for="_edit_form_notimestamp"><input type="checkbox" name="notimestamp" id="_edit_form_notimestamp" value="true" checked="checked" tabindex="9">
        <span class="small">タイムスタンプを変更しない</span></label>
      </div>
  
      <textarea name="original" rows="1" cols="1" style="display:none"></textarea>
    </form>
  </div>
</div>
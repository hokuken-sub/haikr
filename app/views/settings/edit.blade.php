<div class="row">
  <div class="edit_form col-sm-offset-1 col-sm-10 col-xs-12">
    {{ Form::open(array('url' => 'haik-admin/edit', 'style' => 'margin-bottom:0px;', 'id' => 'edit_form_main')) }}
        
      <input type="hidden" name="cmd" value="edit">
      <input type="hidden" name="page" value="">
      <input type="hidden" name="digest" value="">
      <input type="hidden" name="refer" value="">
      <input type="hidden" name="template_name" value="content">
      <input type="hidden" name="pagename" value="{{{ $pagename }}}">
      
        
      <input type="text" name="title" value="{{{ $title }}}" placeholder="ページタイトル" class="col-sm-12 " tabindex="1">
      
      <div class="btn-toolbar">
      </div>
      
      <div id="orgm_toolbox"></div>
      
      <textarea name="contents" id="msg" rows="20" cols="80" placeholder="クリックして文章を入力してください。" tabindex="2" data-exnote="onready" class="col-sm-12">{{{ $md }}}</textarea>
   
      <br>
      <div class="edit_buttons">
        <input type="submit" value="公開" tabindex="5" class="btn btn-primary">
      </div>
  
      <textarea name="original" rows="1" cols="1" style="display:none"></textarea>
    {{ Form::close() }}
  </div>
</div>
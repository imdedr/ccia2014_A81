<?php $this->load->view('header'); ?>
    <div class="container">
      <button type="button" id="start" onclick="startRollCall();" class="btn btn-success">開始點名</button>
      <button type="button" id="stop" onclick="stopRollCall();" style="display:none" class="btn btn-success">停止點名</button>
      <table class="table">
      <caption>點名列表( 點擊出席狀況 即可以變更狀態 )</caption>
      <thead>
        <tr>
          <th>#</th>
          <th>學生姓名</th>
          <th>是否出席</th>
        </tr>
      </thead>
      <tbody>
        <?php $i=1; foreach ($student as $key => $value) { ?>
        <tr id="tr<?=$value->uid; ?>"> <!-- style="background: #FFD1A4;" -->
          <th scope="row"><?=$i++?></th>
          <td><?=$value->name?></td>
          <td><span class="attend" style="display:none;" onclick="unattend( <?=$value->uid?> );" >出席</span><span style="display:none;" class="unattend" onclick="attend( <?=$value->uid?> );">未出席</span><span class="wait">-</span></td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
    </div> <!-- /container -->

<script type="text/javascript">

var student = [];

var rcid = <?=$rcid?>;
var cid = <?=$cid?>;

var domain = '<?=base_url('/');?>';

<?php foreach ($student as $key => $value) { ?>
  student.push( <?=$value->uid?> );
<?php } ?>

$( function() {
  init();


});

function init() {
    $.ajax({
        type: "POST",
        url: domain +  "api/rollcall_record/" + rcid.toString(),
        dataType: 'json'
    })
    .done(function( msg ) {
      // 先變色改出席
      for (i=0; i < student.length; i++) {
        $( '#tr' + student[i].toString() ).css( 'background', '#FFD1A4' );
        $( '#tr' + student[i].toString() + ' td .wait' ).css( 'display', 'none' );
        $( '#tr' + student[i].toString() + ' td .unattend' ).css( 'display', 'inline' );
      }
      // 讀取出席紀錄
      for (i=0; i < msg.record.length; i++) {
        $( '#tr' + msg.record[i].uid.toString() ).css( 'background', 'white' );
        $( '#tr' + msg.record[i].uid.toString() + ' td .attend' ).css( 'display', 'inline' );
        $( '#tr' + msg.record[i].uid.toString() + ' td .unattend' ).css( 'display', 'none' );
      }
      console.log( '初始化完成' );
      setTimeout( update, 1000 );
    });
}

function update() {
    $.ajax({
        type: "POST",
        url: domain +  "api/rollcall_record/" + rcid.toString(),
        dataType: 'json'
    })
    .done(function( msg ) {
      // 讀取出席紀錄
      for (i=0; i < msg.record.length; i++) {
        $( '#tr' + msg.record[i].uid.toString() ).css( 'background', 'white' );
        $( '#tr' + msg.record[i].uid.toString() + ' td .attend' ).css( 'display', 'inline' );
        $( '#tr' + msg.record[i].uid.toString() + ' td .unattend' ).css( 'display', 'none' );
      }
      console.log( '更新完成' );
      setTimeout( update, 1000 );
    });
}

function attend( uid ) {
    $.ajax({
        type: "POST",
        url: domain +  "api/rollcall_edit/" + rcid.toString(),
        dataType: 'json',
        data: { 'uid':uid, 'status':'attend' }
    })
    .done(function( msg ) {
        $( '#tr' + uid.toString() ).css( 'background', 'white' );
        $( '#tr' + uid.toString() + ' td .attend' ).css( 'display', 'inline' );
        $( '#tr' + uid.toString() + ' td .unattend' ).css( 'display', 'none' );
        console.log( '出席！' );
    });
}

function unattend( uid ) {
    $.ajax({
        type: "POST",
        url: domain +  "api/rollcall_edit/" + rcid.toString(),
        dataType: 'json',
        data: { 'uid':uid, 'status':'unattend' }
    })
    .done(function( msg ) {
        $( '#tr' + uid.toString() ).css( 'background', '#FFD1A4' );
        $( '#tr' + uid.toString() + ' td .unattend' ).css( 'display', 'inline' );
        $( '#tr' + uid.toString() + ' td .attend' ).css( 'display', 'none' );
        console.log( '未出席！' );
    });
} 

function startRollCall() {
    $.ajax({
        type: "POST",
        url: domain +  "api/rollcall_start/" + cid.toString(),
        dataType: 'json',
        data: { 'rcid':rcid }
    })
    .done(function( msg ) {
        $( '#start' ).css( 'display', 'none' );
        $( '#stop' ).css( 'display', 'inline' );
        console.log( '開始點名' );
    });
}

function stopRollCall() {
    $.ajax({
        type: "POST",
        url: domain +  "api/rollcall_stop/" + cid.toString(),
        dataType: 'json'
    })
    .done(function( msg ) {
        $( '#stop' ).css( 'display', 'none' );
        $( '#start' ).css( 'display', 'inline' );
        console.log( '結束點名' );
    });
}

</script>
<?php $this->load->view('footer'); ?>


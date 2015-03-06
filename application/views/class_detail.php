<?php $this->load->view('header'); ?>
    <div class="container">
      <table class="table">
        <caption>上課記錄</caption>
        <thead>
          <tr>
            <th>#</th>
            <th>上課時間</th>
            <th>課程進度</th>
            <th>接續課程</th>
          </tr>
        </thead>
        <tbody>
          <?php $i=1; foreach ($session as $key => $value): ?>
          <tr>
            <th scope="row"><?=$i++; ?></th>
            <td><?=date( 'Y-m-d H:i:s', $value->date); ?></td>
            <td><?=$value->textbook; ?> 第<?=$value->page+1; ?>頁</td>
            <td><a target="_blank" href="<?=base_url('/teacher/continue_session/'.$value->ssid); ?>">接續上課</a></td> 
          </tr>
          <?php endforeach ?>
        </tbody>
      </table>
      <br><br>
      <table class="table">
        <caption>點名記錄 <a target="_blank" href="<?=base_url( '/teacher/create_new_rollcall/'.$cid ); ?>">[新增點名紀錄]</a></caption>
        <thead>
          <tr>
            <th>#</th>
            <th>點名日期</th>
            <th>詳細資料</th>
          </tr>
        </thead>
        <tbody>
          <?php $i=1; foreach ($rollcall as $key => $value): ?>
          <tr>
            <th scope="row"><?=$i++; ?></th>
            <td><?=date( 'Y-m-d H:i:s', $value->time); ?></td>
            <td><a target="_blank" href="<?=base_url( '/teacher/rollcall/'.$value->rcid ); ?>">展開</a></td>
          </tr>
          <?php endforeach ?>
        </tbody>
      </table>
      <br><br>
      <table class="table">
        <caption>上課教材</caption>
        <thead>
          <tr>
            <th>#</th>
            <th width="40%">教材名稱</th>
            <th width="30%">上傳日期</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php $i=1; foreach ($textbook as $key => $value): ?>
          <tr>
            <th scope="row"><?=$i++; ?></th>
            <td><?=$value->name;?></td>
            <td><?=date( 'Y-m-d H:i:s', $value->time); ?></td>
            <td><a target="_blank" href="<?=base_url('/teacher/create_new_session/'.$value->ctbid); ?>">建立課程</td>
          </tr>
          <?php endforeach ?>
        </tbody>
      </table>
      <br><br>
      <table class="table">
        <caption>輔助檔案</caption>
        <thead>
          <tr>
            <th>#</th>
            <th>檔案名稱</th>
            <th>上傳日期</th>
          </tr>
        </thead>
        <tbody>
          <?php $i=1; foreach ($file as $key => $value): ?>
          <tr>
            <th scope="row"><?=$i++; ?></th>
            <td><a href="<?=base_url('/file/common/'.$value->path); ?>"><?=$value->name; ?></a></td>
            <td><?=date( 'Y-m-d H:i:s', $value->time); ?></td>
          </tr>
          <?php endforeach ?>
        </tbody>
      </table>
    </div> <!-- /container -->
<?php $this->load->view('footer'); ?>


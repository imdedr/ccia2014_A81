<?php $this->load->view('header'); ?>
    <div class="container">
      <table class="table">
      <caption>課程列表</caption>
      <thead>
        <tr>
          <th>#</th>
          <th>課程名稱</th>
          <th>上課時間</th>
          <th>課程教室</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php $i=1; foreach ($course as $key => $value) { ?>
        <tr>
          <th scope="row"><?=$i++?></th>
          <td><?=$value->name?></td>
          <td><?=str_replace('"', '', $value->time)?></td>
          <td><?=$value->class?></td>
          <td><a href="<?=base_url('/teacher/cla/'.$value->cid); ?>">進入</a></td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
    </div> <!-- /container -->
<?php $this->load->view('footer'); ?>


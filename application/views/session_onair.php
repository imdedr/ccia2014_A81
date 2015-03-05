<!DOCTYPE html>
<html>
<head>
    <script src="<?=base_url('js/jquery-1.11.2.min.js'); ?>"></script>
    <script src="<?=base_url('js/jcanvas.min.js'); ?>"></script>
    <script type="text/javascript" src="<?=base_url('js/noty/packaged/jquery.noty.packaged.min.js'); ?>"></script>
</head>
<body>
<div id="wrap" style="margin: 0 auto; width:1024px; height:768px;">
<canvas id="myCanvas" width="1024" height="768" style="border:1px solid #d3d3d3;">
Your browser does not support the HTML5 canvas tag.</canvas>
</div>
<script type="text/javascript">

    var innerHeight = $(window).height() - 30;
    var innerWidth  = $(window).width()- 30;

    if( innerHeight < 768 || innerWidth < 1024 ) {
        // 計算長寬變形
        var rateHeight = innerHeight / 768.0;
        var rateWidth = innerWidth / 1024.0;

        var smallrate = rateHeight;
        if( rateWidth < rateHeight ) {
            smallrate = rateWidth;
        }
    } else {
        smallrate = 1;
    }

    console.log( 'rate:' + smallrate.toString() );

    var ssid = <?=$ssid; ?>;

    var cid = <?=$cid; ?>;

    var now = <?=$page;?>;

    var hand_last = 0;

    var queue_last = 0;

    var listen_token = '';

    var domain = '<?=base_url('/');?>';

    var page = [];

    <?php foreach ($file_list as $key => $value) { ?>
    page.push( '/file/textbook/<?=$path.'/'.$value;?>' );
    <?php } ?>

    var page_tail = [];
    <?php foreach ($file_list as $key => $value) { ?>
        page_tail.push([]);
    <?php } ?>
    

$( function() {

    // 轉換長寬資訊
    $('#wrap').css( 'width', ( Math.round( 1024 * smallrate ) ).toString() + 'px' );
    $('#wrap').css( 'height', ( Math.round( 768 * smallrate ) ).toString() + 'px' );

    $('#myCanvas').attr('width', Math.round( 1024 * smallrate ));
    $('#myCanvas').attr('height', Math.round( 768 * smallrate ));

    loadPage( now );

    $(window).keydown(function(event){ 
        switch(event.keyCode) { 
            case 38:
                pageUp();
                break;
            case 40:
                pageDown();
                break;
        }
    });

    checkHand();

} );

function loadPage( p ) {
    $('#myCanvas').drawImage({
        source: domain + page[p],
        x: 0, y: 0,
        width: 1024 * smallrate,
        height: 768 * smallrate,
        fromCenter: false
    });

    replay( p );

    $.ajax({
        type: "POST",
        url: domain + "api/update_page/" + ssid.toString(),
        dataType: 'json',
        data: { 'page': p }
    })
    .done(function( msg ) {
        console.log( '更新成功' );
    });

    now = p;
}

function replay( p ) {
    for (i=0; i < page_tail[p].length; i++ ){
        command_parser( page_tail[p][i] );
    }
}

function pageUp() {
    if( now > 0 ) {
        loadPage( now-1 );
    }
}

function pageDown() {
    if( now < page.length -1 ) {
        loadPage( now+1 );
    }
}

function checkHand() {
    console.log( '檢查舉手' );
    $.ajax({
        type: "POST",
        url: domain + "api/hand_check/" + cid.toString(),
        dataType: 'json'
    })
    .done(function( msg ) {
        if( msg.hand.length != 0 ) {
            if( parseInt(msg.hand[0].time) > hand_last ) {
                hand_last = parseInt(msg.hand[0].time);
                hid = parseInt( msg.hand[0].hid );
                noty({
                    text: msg.hand[0].uid + '舉手',
                    buttons: [
                        {
                            addClass: 'btn btn-primary', text: '接受', onClick: function($noty) {
                                $noty.close();
                                noty({text: '接受舉手', type: 'success'});
                                accHand( hid );
                            }
                        },
                        {
                            addClass: 'btn btn-danger', text: '忽略', onClick: function($noty) {
                                $noty.close();
                                setTimeout( checkHand, 1000 );
                            }
                        }
                    ]
                });
            } else {
                setTimeout( checkHand, 1000 );
            }
        } else {
            setTimeout( checkHand, 1000 );
        }
    });
}

function accHand( hid ) {
    $.ajax({
        type: "POST",
        url: domain +  "api/hand_accept/" + hid.toString(),
        dataType: 'json'
    })
    .done(function( msg ) {
        listen_token = msg.token;
        console.log( 'Listen Token: ' + listen_token );
        setTimeout( hand_queue, 500 );
    });
}

function hand_queue() {
    console.log( 'Queue 監視中...' );
    $.ajax({
        type: "POST",
        url: domain +  "api/hand_queue/" + listen_token + "/" + queue_last.toString(),
        dataType: 'json'
    })
    .done(function( msg ) {
        if( msg.queue.length != 0 ) {

            for( i=0; i < msg.queue.length; i++ ) {

                raw = msg.queue[i].command.split( '|' );

                if( raw[0] == 'quit' ) {
                    console.log( '結束聆聽' );
                    noty({text: '同學手放下了！'});
                    checkHand();
                } else {
                    if( raw[0] == 'draw' ) {
                        // 把紀錄存起來
                        page_tail[now].push( msg.queue[i].command );
                    }
                    command_parser( msg.queue[i].command ); // 交給專業的
                    setTimeout( hand_queue, 1000 );
                }

                if( parseInt( msg.queue[i].time ) > queue_last ) {
                    queue_last = parseInt( msg.queue[i].time );
                }
            }

        } else {
            // 沒事就緩速
            setTimeout( hand_queue, 2000 );
        }
    });
}

function command_parser( cmd ) {
    raw = cmd.toString().split( '|' );
    console.log( cmd );
    if( raw[0] == 'flip' ) {
        loadPage( parseInt(raw[1]) );
    } else if( raw[0] == 'draw' ) {
        p1 = eval( raw[1] );
        p2 = eval( raw[2] );
        $('#myCanvas').drawLine({
            strokeStyle: '#000',
            strokeWidth: 3,
            x1: p1[0], y1: p1[1],
            x2: p2[0], y2: p2[1],
            closed: true
        });
    } else {
        alert('不明指令 ' + cmd.toString());
    }
}

</script>

</body>
</html>
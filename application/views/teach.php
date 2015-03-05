<!DOCTYPE html>
<html>
<head>
	<script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
    <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script src='http://127.0.0.1/ccia2014_A81/jcanvas.min.js'></script>
</head>
<body>
<canvas id="myCanvas" width="1024" height="768" style="border:1px solid #d3d3d3;">
Your browser does not support the HTML5 canvas tag.</canvas>
<button onclick="pageUp()">Up</button>
<button onclick="pageDown()">Down</button>
<div id="n" style="display:none; position:absolute; right:150px; top:10px; width:150px;">
    有同學舉手
    <button onclick="accHand()">接受</button>
</div>
<script>

var now = 0;
var domain = 'http://keniver.com/sla';
var last_hand = 0;
var hid = 0;
var listen_token = '';
var last_queue = 0;

var page = [];
page.push( '/file/textbook/0001/crawler_detection/crawler%20detection%20-%20pre.001.jpg' );
page.push( '/file/textbook/0001/crawler_detection/crawler%20detection%20-%20pre.002.jpg' );
page.push( '/file/textbook/0001/crawler_detection/crawler%20detection%20-%20pre.003.jpg' );
page.push( '/file/textbook/0001/crawler_detection/crawler%20detection%20-%20pre.004.jpg' );
page.push( '/file/textbook/0001/crawler_detection/crawler%20detection%20-%20pre.005.jpg' );
page.push( '/file/textbook/0001/crawler_detection/crawler%20detection%20-%20pre.006.jpg' );
page.push( '/file/textbook/0001/crawler_detection/crawler%20detection%20-%20pre.007.jpg' );
page.push( '/file/textbook/0001/crawler_detection/crawler%20detection%20-%20pre.008.jpg' );
page.push( '/file/textbook/0001/crawler_detection/crawler%20detection%20-%20pre.009.jpg' );
page.push( '/file/textbook/0001/crawler_detection/crawler%20detection%20-%20pre.010.jpg' );
page.push( '/file/textbook/0001/crawler_detection/crawler%20detection%20-%20pre.011.jpg' );
page.push( '/file/textbook/0001/crawler_detection/crawler%20detection%20-%20pre.012.jpg' );
page.push( '/file/textbook/0001/crawler_detection/crawler%20detection%20-%20pre.013.jpg' );

$( function() {
   drawThePPT( domain + page[0] );
   checkHand();
});

function drawThePPT( path ) {
	$('#myCanvas').drawImage({
        source: path,
    	x: 0, y: 0,
    	width: 1024,
        height: 768,
        fromCenter: false
    });
}

function pageUp() {
	if( now != 0 ) {
		now--;
		drawThePPT( domain + page[now] );
	}
}

function pageDown() {
	if( now != 13 ) {
		now++;
		drawThePPT( domain + page[now] );
	}
}

function checkHand() {
	$.ajax({
        type: "POST",
        url: "http://keniver.com/sla/api/hand_check/1",
        dataType: 'json'
    })
    .done(function( msg ) {
        if( msg.hand.length != 0 ) {
        	$('#n').css( 'display', 'block' );
        	if( parseInt(msg.hand[0].time) > last_hand ) {
        		last_hand = parseInt(msg.hand[0].time);
        		hid = parseInt( msg.hand[0].hid );
        	    alert(  msg.hand[0].uid + '舉手' );
            } else {
            	setTimeout( checkHand, 1000 );
            }
        }
    });
}

function accHand() {
    $.ajax({
        type: "POST",
        url: "http://keniver.com/sla/api/hand_accept/" + hid.toString(),
        dataType: 'json'
    })
    .done(function( msg ) {
    	$('#n').css( 'display', 'none' );
    	listen_token = msg.token;
    	alert( listen_token );
        setTimeout( hand_queue, 500 );
    });
}

function hand_queue() {
	$.ajax({
        type: "POST",
        url: "http://keniver.com/sla/api/hand_queue/" + listen_token + "/" + last_queue.toString(),
        dataType: 'json'
    })
    .done(function( msg ) {
    	$('#n').css( 'display', 'none' );
    	if( msg.queue.length != 0 ) {
    		for( i=0; i < msg.queue.length; i++ ) {
    			raw = msg.queue[i].command.split( '|' );
    			if( raw[0] == 'quit' ) {
    				alert( '結束聆聽' );
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
    				setTimeout( hand_queue, 500 );
    			} else if( raw[0] == 'flip' ) {
    				drawThePPT( domain + page[parseInt(raw[1]) + 1] );
    				setTimeout( hand_queue, 500 );
    			} else {
    				alert( '不明白' );
    			}
    			if( parseInt( msg.queue[i].time ) > last_queue ) {
    				last_queue = parseInt( msg.queue[i].time );
    			}
    		}
    	} else {
    		setTimeout( hand_queue, 2000 );
    	}
    });
}

</script>

</body>
</html>
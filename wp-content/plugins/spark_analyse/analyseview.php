<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/18
 * Time: 20:52
 */
if ( ! function_exists( 'model' ) ) {
    require_once( 'model_drawing.php' );
}
if ( ! function_exists( 'timechart' ) ) {
    require_once( 'timechart.php' );
}

global $time,$time1,$time2,$time3,$time4,$time5,$time6,$time7;
$time=explode(" ",timechart());
$time1=$time[0];
$time2=$time[1];
$time3=$time[2];
$time4=$time[3];
$time5=$time[4];
$time6=$time[5];
$time7=$time[6];
$vtime=explode(" ",wikiviewtimechart());
$vtime1=$vtime[0];
$vtime2=$vtime[1];
$vtime3=$vtime[2];
$vtime4=$vtime[3];
$vtime5=$vtime[4];
$vtime6=$vtime[5];
$vtime7=$vtime[6];
$qtime=explode(" ",questiontimechart());
$qtime1=$qtime[0];
$qtime2=$qtime[1];
$qtime3=$qtime[2];
$qtime4=$qtime[3];
$qtime5=$qtime[4];
$qtime6=$qtime[5];
$qtime7=$qtime[6];
$atime=explode(" ",answertimechart());
$atime1=$atime[0];
$atime2=$atime[1];
$atime3=$atime[2];
$atime4=$atime[3];
$atime5=$atime[4];
$atime6=$atime[5];
$atime7=$atime[6];
$draw=explode(" ",model());
$draw1=$draw[0];$draw2=$draw[1];$draw3=$draw[2];$draw4=$draw[3];$draw5=$draw[4];$draw6=$draw[5];
$draw7=$draw[6];$draw8=$draw[7];$draw9=$draw[8];$draw10=$draw[9];
function spark_settings_submenu_page()
{   global $time1;
    ?>
    <!DOCTYPE html>
    <html >
   <head>
        <meta charset="utf-8">
        <title>用户画像</title>
        <link href="//netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.static.runoob.com/libs/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://cdn.static.runoob.com/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src="https://cdn.static.runoob.com/libs/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo plugins_url('miaov_style.css')?>" />
       <script type="text/javascript" src="<?php echo site_url('wp-content/plugins/spark_analyse/miaov.js')?>"></script>
       <script type="text/javascript" >if( typeof html5jp == 'undefined' ) {
               html5jp = new Object();
           }
           if( typeof html5jp.graph == 'undefined' ) {
               html5jp.graph = new Object();
           }
           html5jp.graph.line = function (id) {
               var elm = document.getElementById(id);
               if(! elm) { return; }
               if(elm.nodeName != "CANVAS") { return; }
               if(elm.parentNode.nodeName != "DIV") { return; };
               this.canvas = elm;
               if ( ! this.canvas ){ return; }
               if ( ! this.canvas.getContext ){ return; }
               this.ctx = this.canvas.getContext('2d');
               this.canvas.style.margin = "0";
               this.canvas.parentNode.style.position = "relative";
               this.canvas.parentNode.style.padding = "0";
           };

           html5jp.graph.line.prototype.draw = function(items, inparams) {
               if( ! this.ctx ) {return;}
               var params = {
                   x: [],
                   y: [],
                   yMax: null,
                   yMin: 0,
                   backgroundColor: "#ffffff",
                   gbackgroundColor: "#dddddd",
                   gGradation: true,
                   lineWidth: 1,
                   dotRadius: 3,
                   dotType: "disc",
                   hLineWidth: 2,
                   hLineType: "dotted",
                   hLineColor: "#aaaaaa",
                   xAxisWidth: 2,
                   xAxisColor: "#000000",
                   yAxisWidth: 2,
                   yAxisColor: "#000000",
                   xScaleColor: "#000000",
                   xScaleFontSize: "1px",
                   xScaleFontFamily: "Arial,sans-serif",
                   yScaleColor: "#000000",
                   yScaleFontSize: "1px",
                   yScaleFontFamily: "Arial,sans-serif",
                   xCaptionColor: "#000000",
                   xCaptionFontSize: "1px",
                   xCaptionFontFamily: "Arial,sans-serif",
                   yCaptionColor: "#000000",
                   yCaptionFontSize: "1px",
                   yCaptionFontFamily: "Arial,sans-serif",
                   dLabel: true,
                   dLabelColor: "#000000",
                   dLabelFontSize: "1px",
                   dLabelFontFamily: "Arial,sans-serif",
                   legend: true,
                   legendFontSize: "1px",
                   legendFontFamily: "Arial,sans-serif",
                   legendColor: "#000000"
               };
               if( inparams && typeof(inparams) == 'object' ) {
                   for( var key in inparams ) {
                       params[key] = inparams[key];
                   }
               }
               this.params = params;
               if( params.backgroundColor ) {
                   this.ctx.beginPath();
                   this.ctx.fillStyle = params.backgroundColor;
                   this.ctx.fillRect(0, 0, this.canvas.width, this.canvas.height);
               }
               if(this.canvas.width / this.canvas.height < 1.5 || this.canvas.height < 200) {
                   params.legend == false;
               }
               var canvas_pos = this._getElementAbsPos(this.canvas);
               var cpos = {
                   x0: this.canvas.width * 0.1,
                   y0: this.canvas.height * 0.9,
                   x1: this.canvas.width * 0.9,
                   y1: this.canvas.height * 0.1
               };
               if( typeof(params.x) == "object" && params.x.length > 0) {
                   cpos.y0 = this.canvas.height *0.8;
               }
               if( typeof(params.y) == "object" && params.y.length > 0) {
                   cpos.x0 = this.canvas.width *0.05;
                   cpos.y1 = this.canvas.height *0.1;
               }
               if(params.legend == true) {
                   cpos.x1 = this.canvas.width * 0.88;
               }
               cpos.w = cpos.x1 - cpos.x0;
               cpos.h = cpos.y0 - cpos.y1;
               var item_num = items.length;
               if(item_num > 10) { item_num = 10; }
               if(params.legend == true) {
                   var legend_tmp_s = this._getTextBoxSize('あTEST', params.legendFontSize, params.legendFontFamily);
                   var lpos = {
                       x: Math.round( cpos.x1 ),
                       y: Math.round( ( this.canvas.height - ( legend_tmp_s.h * item_num + legend_tmp_s.h * 0.2 * (item_num - 1) ) ) / 2 ),
                       h: legend_tmp_s.h
                   };
                   lpos.cx = lpos.x + Math.round( lpos.h * 2.5 );
                   lpos.cw = this.canvas.width - lpos.cx;
               }
               if(params.gGradation == true) {
                   this.ctx.beginPath();
                   this.ctx.moveTo(cpos.x0, cpos.y0);
                   this.ctx.lineTo(cpos.x1, cpos.y0);
                   this.ctx.lineTo(cpos.x1, cpos.y1);
                   this.ctx.lineTo(cpos.x0, cpos.y1);
                   this.ctx.closePath();
                   var radgrad = this.ctx.createLinearGradient(cpos.x0,cpos.y1,cpos.x0,cpos.y0);
                   var o_gbc = this._csscolor2rgb(params.gbackgroundColor);
                   var gbc = o_gbc.r + "," + o_gbc.g + "," + o_gbc.b;
                   radgrad.addColorStop(0, "rgb(" + gbc + ")");
                   radgrad.addColorStop(1, "rgb(255,255,255)");
                   this.ctx.fillStyle = radgrad;
                   this.ctx.fill();
               } else {
                   this.ctx.fillStyle = params.gbackgroundColor;
                   this.ctx.fillRect(cpos.x0, cpos.y1, cpos.w, cpos.h);
               }
               var max_v = null;
               var min_v = null;
               var max_n = 0;
               if(params.y.length > 1) {
                   max = params.y[ params.y.length - 1 ];
               }
               for(var i=0; i<item_num; i++) {
                   var n = items[i].length;
                   if(n < 2) { continue; }
                   for(var j=1; j<n; j++) {
                       var v = items[i][j];
                       if( isNaN(v) ) {
                           throw new Error('invalid graph item data.' + n);
                       }
                       if(max_v == null) {
                           max_v = v;
                       } else if(v >= max_v) {
                           max_v = v;
                       }
                       if(min_v == null) {
                           min_v = v;
                       } else if(v <= min_v) {
                           min_v = v;
                       }
                   }
                   if(n - 1 >= max_n) {
                       max_n = n - 1;
                   }
               }
               if( typeof(params.yMin) != "number" ) {
                   params.yMin = 0;
               }
               if( typeof(params.yMax) != "number" ) {
                   params.yMax = max_v + Math.abs(max_v - min_v) * 0.1;
               }
               var v_range = Math.abs( params.yMax - params.yMin );
               if( typeof(params.hLineWidth) == "number" && params.hLineWidth > 0 ) {
                   var h_line_type = "dashed";
                   if( params.hLineType.match(/^(solid|dashed|dotted)$/i) ) {
                       h_line_type = params.hLineType;
                   }
                   for(var i=1; i<params.y.length; i++) {
                       var aline_x0 = cpos.x0;
                       var aline_y0 = Math.round( cpos.y0 - cpos.h * ( params.y[i] - params.yMin ) / v_range );
                       var aline_x1 = cpos.x1;
                       this._draw_h_aline(aline_x0, aline_y0, aline_x1, params.hLineWidth, h_line_type, params.hLineColor);
                   }
               }
               var colors = ["24,41,206", "198,0,148", "214,0,0", "255,156,0", "33,156,0", "33,41,107", "115,0,90", "132,0,0", "165,99,0", "24,123,0"];
               var plots = new Array();
               for(var i=0; i<item_num; i++) {
                   this.ctx.beginPath();
                   this.ctx.lineJoin = "round";
                   plots[i] = new Array();
                   var n = items[i].length;
                   for(var j=1; j<n; j++) {
                       var v = items[i][j];
                       var p = {
                           x: Math.round( cpos.x0 + cpos.w * ( j - 0.5 ) / max_n ),
                           y: Math.round( cpos.y0 - cpos.h * ( v - params.yMin ) / v_range ),
                           v: v
                       }
                       plots[i].push(p);
                       if(j == 1) {
                           this.ctx.moveTo(p.x, p.y);
                       } else {
                           this.ctx.lineTo(p.x, p.y);
                       }
                   }
                   var line_width = 1;
                   if( typeof(params.lineWidth) == "object" && ! isNaN(params.lineWidth[i])) {
                       line_width = params.lineWidth[i];
                   } else if( typeof(params.lineWidth) == "number" && ! isNaN(params.lineWidth)) {
                       line_width = params.lineWidth;
                   }
                   this.ctx.lineWidth = line_width;
                   var line_color = "rgb(" + colors[i] + ")";
                   this.ctx.strokeStyle = line_color;
                   this.ctx.stroke();
                   var dot_rad = null;
                   if( typeof(params.dotRadius) == "object" && ! isNaN(params.dotRadius[i]) && params.dotRadius[i] > 0 ) {
                       dot_rad = params.dotRadius[i];
                   } else if( typeof(params.dotRadius) == "number" && ! isNaN(params.dotRadius) && params.dotRadius > 0 ) {
                       dot_rad = params.dotRadius;
                   }
                   var dot_type = null;
                   if( typeof(params.dotType) == "object" && typeof(params.dotType[i]) == "string" ) {
                       dot_type = params.dotType[i];
                   } else if( typeof(params.dotType) == "string" ) {
                       dot_type = params.dotType;
                   } else {
                       dot_type = "disc";
                   }
                   if(dot_rad > 0) {
                       for(var k=0; k<plots[i].length; k++) {
                           this._draw_dot(plots[i][k].x, plots[i][k].y, dot_rad, dot_type, colors[i]);
                       }
                   }
                   if(params.dLabel == true) {
                       for(var k=0; k<plots[i].length; k++) {
                           if(plots[i][k].x < cpos.x0 || plots[i][k].x > cpos.x1 || plots[i][k].y > cpos.y0 || plots[i][k].y < cpos.y1) {
                               continue;
                           }
                           var dlabel = plots[i][k].v.toString();
                           var margin = 1;
                           if(dot_rad != null && dot_rad > 0) {
                               margin += dot_rad;
                           }
                           var s = this._getTextBoxSize(dlabel, params.dLabelFontSize, params.dLabelFontFamily);
                           var dlabel_x = plots[i][k].x - Math.round( s.w / 2 );
                           var dlabel_y = plots[i][k].y - Math.round( s.h ) - margin+30;
                           this._drawText(dlabel_x, dlabel_y, dlabel, params.dLabelFontSize, params.dLabelFontFamily, params.dLabelColor);
                       }
                   }
                   if(params.legend == true) {
                       this._drawText(lpos.cx, lpos.y, items[i][0], params.legendFontSize, params.legendFontFamily, params.legendColor);
                       this._draw_h_aline(lpos.x, Math.round(lpos.y+lpos.h/2), lpos.x + lpos.h*2, line_width, "solid", line_color);
                       if(dot_rad > 0) {
                           this._draw_dot(Math.round(lpos.x+lpos.h), Math.round(lpos.y+lpos.h/2), dot_rad, dot_type, colors[i]);
                       }
                       lpos.y = lpos.y + lpos.h *1.2;
                   }
               }
               this.ctx.fillStyle = params.backgroundColor;
               this.ctx.fillRect(cpos.x0, 0, cpos.w, cpos.y1);
               this.ctx.fillRect(cpos.x0, cpos.y0, cpos.w, this.canvas.height - cpos.y0);
               if( typeof(params.xAxisWidth) == "number" && params.xAxisWidth > 0 ) {
                   this._draw_h_aline(cpos.x0, cpos.y0, cpos.x1, params.xAxisWidth, "solid", params.xAxisColor);
               }
               if( typeof(params.yAxisWidth) == "number" && params.yAxisWidth > 0 ) {
                   this._draw_v_aline(cpos.x0, cpos.y0, cpos.y1, params.yAxisWidth, "solid", params.yAxisColor);
               }
               var xscale_y_under = 0;
               for(var i=1; i<=max_n; i++) {
                   if( typeof(params.x[i] ) != "string" ) { continue; }
                   if(params.x[i] == "") { continue; }
                   var s = this._getTextBoxSize(params.x[i], params.xScaleFontSize, params.xScaleFontFamily);
                  // var xscale_x = Math.round( cpos.x0 + cpos.w * ( i - 0.5 ) / max_n ) - Math.round( s.w / 2 )-100;
                   var xscale_x = Math.round( cpos.x0 + cpos.w * ( i - 0.5 ) / max_n );
                   var xscale_y = cpos.y0 +40;
                   this._drawText(xscale_x, xscale_y, params.x[i], params.xScaleFontSize, params.xScaleFontFamily, params.xScaleColor);
                   if(xscale_y + s.h >= xscale_y_under) {
                       xscale_y_under = xscale_y + s.h;
                   }
               }
               var yscale_y_top = this.canvas.height;
               for(var i=1; i<params.y.length; i++) {
                   if( typeof(params.y[i] ) != "number" ) { continue; }
                   var v = params.y[i].toString();
                   if(v == "") { continue; }
                   if(params.y[i] < params.yMin || params.y[i] > params.yMax) { continue; }
                   var s = this._getTextBoxSize(v, params.yScaleFontSize, params.yScaleFontFamily);
                   var yscale_y = Math.round( cpos.y0 - cpos.h * ( params.y[i] - params.yMin ) / v_range ) - Math.round( s.h / 2 )+40;
                   var yscale_x = Math.round( cpos.x0 - s.w ) - 5;
                   this._drawText(yscale_x, yscale_y, v, params.yScaleFontSize, params.yScaleFontFamily, params.yScaleColor);
                   if(yscale_y <= yscale_y_top) {
                       yscale_y_top = yscale_y;
                   }
               }
               if( typeof(params.x[0]) == "string" && params.x[0] != "" ) {
                   var s = this._getTextBoxSize(params.x[0], params.xCaptionFontSize, params.xCaptionFontFamily);
                   var xcaption_y = cpos.y0 + 5;
                   if(xscale_y_under > 0) {
                       xcaption_y = xscale_y_under + 5;
                   }
                   var xcaption_x = Math.round( cpos.x0 + ( cpos.w / 2 ) - ( s.w / 2 ) );
                   this._drawText(xcaption_x, xcaption_y, params.x[0], params.xCaptionFontSize, params.xCaptionFontFamily, params.xCaptionColor);
               }
               if( typeof(params.y[0]) == "string" && params.y[0] != "" ) {
                   var s = this._getTextBoxSize(params.y[0], params.yCaptionFontSize, params.yCaptionFontFamily);
                   var ycaption_y = yscale_y_top - s.h - 5;
                   if(yscale_y_top > cpos.y1) {
                       ycaption_y = cpos.y1 - s.h - 5;
                   }
                   var ycaption_x = Math.round( cpos.x0 - ( s.w / 2 ) );
                   if(ycaption_x < 5) {
                       ycaption_x = 5;
                   }
                   this._drawText(ycaption_x, ycaption_y, params.y[0], params.yCaptionFontSize, params.yCaptionFontFamily, params.yCaptionColor);
               }
           };

           html5jp.graph.line.prototype._draw_v_aline = function(x0, y0, y1, width, type, color) {
               color = this._csscolor2rgb(color);
               this.ctx.beginPath();
               color = "rgb(" + color.r + "," + color.g + "," + color.b + ")"
               this.ctx.strokeStyle = color;
               this.ctx.lineWidth = width;
               if(type == "solid") {
                   this.ctx.moveTo(x0, y0);
                   this.ctx.lineTo(x0, y1);
                   this.ctx.stroke();
               } else if( type == "dashed" || (type == "dotted" && width < 2) ) {
                   var y = y0;
                   while(1) {
                       if(y - width*4 < y1) { break; }
                       this.ctx.moveTo(x0, y);
                       y = y - width * 4;
                       this.ctx.lineTo(x0, y);
                       this.ctx.stroke();
                       if(y - width*2 < y1) { break; }
                       y = y - width*2;
                   }
               } else if(type == "dotted") {
                   this.ctx.fillStyle = color;
                   var y = y0;
                   while(1) {
                       if(y - width*2 < y1) { break; }
                       this.ctx.arc(x0, y, width/2, 0, Math.PI*2, false);
                       this.ctx.fill();
                       if(y - width*2 < y1) { break; }
                       y = y - width*2;
                   }
               }
           };
           html5jp.graph.line.prototype._draw_h_aline = function(x0, y0, x1, width, type, color) {
               color = this._csscolor2rgb(color);
               this.ctx.beginPath();
               color = "rgb(" + color.r + "," + color.g + "," + color.b + ")"
               this.ctx.strokeStyle = color;
               this.ctx.lineWidth = width;
               if(type == "solid") {
                   this.ctx.moveTo(x0, y0);
                   this.ctx.lineTo(x1, y0);
                   this.ctx.stroke();
               } else if( type == "dashed" || (type == "dotted" && width < 2) ) {
                   var x = x0;
                   while(1) {
                       if(x + width*4 > x1) { break; }
                       this.ctx.moveTo(x, y0);
                       x = x + width * 4;
                       this.ctx.lineTo(x, y0);
                       this.ctx.stroke();
                       if(x + width*2 > x1) { break; }
                       x = x + width*2;
                   }
               } else if(type == "dotted") {
                   this.ctx.fillStyle = color;
                   var x = x0;
                   while(1) {
                       if(x + width*2 > x1) { break; }
                       this.ctx.arc(x, y0, width/2, 0, Math.PI*2, false);
                       this.ctx.fill();
                       if(x + width*2 > x1) { break; }
                       x = x + width*2;
                   }
               }
           };
           html5jp.graph.line.prototype._draw_dot = function(x, y, rad, type, color) {
               this.ctx.beginPath();
               this.ctx.fillStyle = "rgb(" + color + ")";
               if( type == "disc" ) {
                   this.ctx.arc(x, y, rad, 0, Math.PI*2, false);
               } else if( type == "square" ) {
                   this.ctx.moveTo(x-rad, y-rad);
                   this.ctx.lineTo(x+rad, y-rad);
                   this.ctx.lineTo(x+rad, y+rad);
                   this.ctx.lineTo(x-rad, y+rad);
               } else if( type == "triangle" ) {
                   this.ctx.moveTo(x, y-rad);
                   this.ctx.lineTo(x+rad, y+rad);
                   this.ctx.lineTo(x-rad, y+rad);
               } else if( type == "i-triangle" ) {
                   this.ctx.moveTo(x, y+rad);
                   this.ctx.lineTo(x+rad, y-rad);
                   this.ctx.lineTo(x-rad, y-rad);
               } else if( type == "diamond" ) {
                   this.ctx.moveTo(x, y-rad);
                   this.ctx.lineTo(x+rad, y);
                   this.ctx.lineTo(x, y+rad);
                   this.ctx.lineTo(x-rad, y);
               } else {
                   this.ctx.arc(x, y, rad, 0, Math.PI*2, false);
               }
               this.ctx.closePath();
               this.ctx.fill();
           };
           html5jp.graph.line.prototype._drawText = function(x, y, text, font_size, font_family, color) {
               var div = document.createElement('DIV');
               div.appendChild( document.createTextNode(text) );
               div.style.fontSize = font_size;
               div.style.fontFamily = font_family;
               div.style.color = color;
               div.style.margin = "0";
               div.style.padding = "0";
               div.style.position = "absolute";
               div.style.left = x.toString() + "px";
               div.style.top = y.toString() + "px";
               this.canvas.parentNode.appendChild(div);
           }
           html5jp.graph.line.prototype._getTextBoxSize = function(text, font_size, font_family) {
               var tmpdiv = document.createElement('DIV');
               tmpdiv.appendChild( document.createTextNode(text) );
               tmpdiv.style.fontSize = font_size;
               tmpdiv.style.fontFamily = font_family;
               tmpdiv.style.margin = "0";
               tmpdiv.style.padding = "0";
               tmpdiv.style.visible = "hidden";
               tmpdiv.style.position = "absolute";
               tmpdiv.style.left = "0px";
               tmpdiv.style.top = "0px";
               this.canvas.parentNode.appendChild(tmpdiv);
               var o = {
                   w: tmpdiv.offsetWidth,
                   h: tmpdiv.offsetHeight
               };
               tmpdiv.parentNode.removeChild(tmpdiv);
               return o;
           }
           html5jp.graph.line.prototype._getElementAbsPos = function(elm) {
               var obj = new Object();
               obj.x = elm.offsetLeft;
               obj.y = elm.offsetTop;
               while(elm.offsetParent) {
                   elm = elm.offsetParent;
                   obj.x += elm.offsetLeft;
                   obj.y += elm.offsetTop;
               }
               return obj;
           };
           html5jp.graph.line.prototype._csscolor2rgb = function (c) {
               if( ! c ) { return null; }
               var color_map = {
                   black: "#000000",
                   gray: "#808080",
                   silver: "#c0c0c0",
                   white: "#ffffff",
                   maroon: "#800000",
                   red: "#ff0000",
                   purple: "#800080",
                   fuchsia: "#ff00ff",
                   green: "#008000",
                   lime: "#00FF00",
                   olive: "#808000",
                   yellow: "#FFFF00",
                   navy: "#000080",
                   blue: "#0000FF",
                   teal: "#008080",
                   aqua: "#00FFFF"
               };
               c = c.toLowerCase();
               var o = new Object();
               if( c.match(/^[a-zA-Z]+$/) && color_map[c] ) {
                   c = color_map[c];
               }
               var m = null;
               if( m = c.match(/^\#([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i) ) {
                   o.r = parseInt(m[1], 16);
                   o.g = parseInt(m[2], 16);
                   o.b = parseInt(m[3], 16);
               } else if( m = c.match(/^\#([a-f\d]{1})([a-f\d]{1})([a-f\d]{1})$/i) ) {
                   o.r = parseInt(m[1]+"0", 16);
                   o.g = parseInt(m[2]+"0", 16);
                   o.b = parseInt(m[3]+"0", 16);
               } else if( m = c.match(/^rgba*\(\s*(\d+),\s*(\d+),\s*(\d+)/i) ) {
                   o.r = m[1];
                   o.g = m[2];
                   o.b = m[3];
               } else if( m = c.match(/^rgba*\(\s*(\d+)\%,\s*(\d+)\%,\s*(\d+)\%/i) ) {
                   o.r = Math.round(m[1] * 255 / 100);
                   o.g = Math.round(m[2] * 255 / 100);
                   o.b = Math.round(m[3] * 255 / 100);
               } else {
                   return null;
               }
               return o;
           };
       </script>
       <script type="text/javascript">
           window.onload = function() {
               var lg = new html5jp.graph.line("sample");
               if( ! lg ) { return; }
               var items = [
                   ["编辑", '<?php time1()?>', '<?php time2()?>','<?php time3()?>','<?php time4()?>',  "<?php time5()?>", " <?php time6()?>", '<?php time7()?>'],
                   ["评论", '<?php vtime1()?>', '<?php vtime2()?>','<?php vtime3()?>','<?php vtime4()?>',  "<?php vtime5()?>", " <?php vtime6()?>", '<?php vtime7()?>']
               ];
               var params = {
                   x: [ "时间分布", "0-8","8-11", "11-14","14-17","17-20","20-22","22-24"],
                   y: ["wiki编辑浏览时间分布", 0, 2, 4, 6, 8,10],
                   yMax: 10,
                   yMin: 0,
                   lineWidth: [1,2],
                   dotRadius: [3,4],
                   dotType: ["disc", "square"]
               };
               lg.draw(items, params);
               var i=0;
               var oTag=null;


               var a = new html5jp.graph.line("question");
               if( ! a ) { return; }
               var item = [
                   ["提问", '<?php qtime1()?>', '<?php qtime2()?>','<?php qtime3()?>','<?php qtime4()?>',  "<?php qtime5()?>", " <?php qtime6()?>", '<?php qtime7()?>'],
                   ["回答",'<?php atime1()?>', '<?php atime2()?>','<?php atime3()?>','<?php atime4()?>',  "<?php atime5()?>", " <?php atime6()?>", '<?php atime7()?>']
               ];
               var param = {
                   x: [ "时间分布", "0-8","8-11", "11-14","14-17","17-20","20-22","22-24"],
                   y: ["问答时间分布", 0, 2, 4, 6, 8,10],
                   yMax: 10,
                   yMin: 0,
                   lineWidth: [1,2],
                   dotRadius: [3,4],
                   dotType: ["disc", "square"]
               };
               a.draw(item, param);



               oDiv=document.getElementById('mokuai');

               aA=oDiv.getElementsByTagName('a');

               for(i=0;i<aA.length;i++)
               {
                   oTag={};

                   oTag.offsetWidth=aA[i].offsetWidth;
                   oTag.offsetHeight=aA[i].offsetHeight;

                   mcList.push(oTag);
               }

               sineCosine( 0,0,0 );

               positionAll();

               oDiv.onmouseover=function ()
               {
                   active=true;
               };

               oDiv.onmouseout=function ()
               {
                   active=false;
               };

               oDiv.onmousemove=function (ev)
               {
                   var oEvent=window.event || ev;

                   mouseX=oEvent.clientX-(oDiv.offsetLeft+oDiv.offsetWidth/2);
                   mouseY=oEvent.clientY-(oDiv.offsetTop+oDiv.offsetHeight/2);

                   mouseX/=5;
                   mouseY/=5;
               };

               setInterval(update, 30);
           };
           var radius = 120;
           var dtr = Math.PI/180;
           var d=300;

           var mcList = [];
           var active = false;
           var lasta = 1;
           var lastb = 1;
           var distr = true;
           var tspeed=10;
           var size=250;

           var mouseX=0;
           var mouseY=0;

           var howElliptical=1;

           var aA=null;
           var oDiv=null;



           function update()
           {
               var a;
               var b;

               if(active)
               {
                   a = (-Math.min( Math.max( -mouseY, -size ), size ) / radius ) * tspeed;
                   b = (Math.min( Math.max( -mouseX, -size ), size ) / radius ) * tspeed;
               }
               else
               {
                   a = lasta * 0.98;
                   b = lastb * 0.98;
               }

               lasta=a;
               lastb=b;

               if(Math.abs(a)<=0.01 && Math.abs(b)<=0.01)
               {
                   return;
               }

               var c=0;
               sineCosine(a,b,c);
               for(var j=0;j<mcList.length;j++)
               {
                   var rx1=mcList[j].cx;
                   var ry1=mcList[j].cy*ca+mcList[j].cz*(-sa);
                   var rz1=mcList[j].cy*sa+mcList[j].cz*ca;

                   var rx2=rx1*cb+rz1*sb;
                   var ry2=ry1;
                   var rz2=rx1*(-sb)+rz1*cb;

                   var rx3=rx2*cc+ry2*(-sc);
                   var ry3=rx2*sc+ry2*cc;
                   var rz3=rz2;

                   mcList[j].cx=rx3;
                   mcList[j].cy=ry3;
                   mcList[j].cz=rz3;

                   per=d/(d+rz3);

                   mcList[j].x=(howElliptical*rx3*per)-(howElliptical*2);
                   mcList[j].y=ry3*per;
                   mcList[j].scale=per;
                   mcList[j].alpha=per;

                   mcList[j].alpha=(mcList[j].alpha-0.6)*(10/6);
               }

               doPosition();
               depthSort();
           }

           function depthSort()
           {
               var i=0;
               var aTmp=[];

               for(i=0;i<aA.length;i++)
               {
                   aTmp.push(aA[i]);
               }

               aTmp.sort
               (
                   function (vItem1, vItem2)
                   {
                       if(vItem1.cz>vItem2.cz)
                       {
                           return -1;
                       }
                       else if(vItem1.cz<vItem2.cz)
                       {
                           return 1;
                       }
                       else
                       {
                           return 0;
                       }
                   }
               );

               for(i=0;i<aTmp.length;i++)
               {
                   aTmp[i].style.zIndex=i;
               }
           }

           function positionAll()
           {
               var phi=0;
               var theta=0;
               var max=mcList.length;
               var i=0;

               var aTmp=[];
               var oFragment=document.createDocumentFragment();

               //随机排序
               for(i=0;i<aA.length;i++)
               {
                   aTmp.push(aA[i]);
               }

               aTmp.sort
               (
                   function ()
                   {
                       return Math.random()<0.5?1:-1;
                   }
               );

               for(i=0;i<aTmp.length;i++)
               {
                   oFragment.appendChild(aTmp[i]);
               }

               oDiv.appendChild(oFragment);

               for( var i=1; i<max+1; i++){
                   if( distr )
                   {
                       phi = Math.acos(-1+(2*i-1)/max);
                       theta = Math.sqrt(max*Math.PI)*phi;
                   }
                   else
                   {
                       phi = Math.random()*(Math.PI);
                       theta = Math.random()*(2*Math.PI);
                   }
                   //坐标变换
                   mcList[i-1].cx = radius * Math.cos(theta)*Math.sin(phi);
                   mcList[i-1].cy = radius * Math.sin(theta)*Math.sin(phi);
                   mcList[i-1].cz = radius * Math.cos(phi);

                   aA[i-1].style.left=mcList[i-1].cx+oDiv.offsetWidth/2-mcList[i-1].offsetWidth/2+'px';
                   aA[i-1].style.top=mcList[i-1].cy+oDiv.offsetHeight/2-mcList[i-1].offsetHeight/2+'px';
               }
           }

           function doPosition()
           {
               var l=oDiv.offsetWidth/2;
               var t=oDiv.offsetHeight/2;
               for(var i=0;i<mcList.length;i++)
               {
                   aA[i].style.left=mcList[i].cx+l-mcList[i].offsetWidth/2+'px';
                   aA[i].style.top=mcList[i].cy+t-mcList[i].offsetHeight/2+'px';

                   aA[i].style.fontSize=Math.ceil(12*mcList[i].scale/2)+8+'px';

                   aA[i].style.filter="alpha(opacity="+100*mcList[i].alpha+")";
                   aA[i].style.opacity=mcList[i].alpha;
               }
           }

           function sineCosine( a, b, c)
           {
               sa = Math.sin(a * dtr);
               ca = Math.cos(a * dtr);
               sb = Math.sin(b * dtr);
               cb = Math.cos(b * dtr);
               sc = Math.sin(c * dtr);
               cc = Math.cos(c * dtr);
           }

       </script>
    </head>
    <STYLE TYPE="text/css">
        body {background:blue;}
        #mokuai {position:relative; left:300px;width:150px; height:50px; top:20px ;margin: 20px auto 0; }
        #mokuai a {position:absolute; top:0px; left:0px; font-family: Microsoft YaHei; color:#fff; font-weight:bold; text-decoration:none; padding: 3px 6px; }
        #mokuai a:hover {border: 1px solid #eee; background: #000; }
        #mokuai .blue {color:blue;}
        #mokuai .red {color:red;}
        #mokuai .yellow {color:yellow;}
        canvas {border:1px solid #4c4c4c;}
        p { font: 16px Microsoft YaHei; text-align: center; color: #ba0c0c; }
        p a { font-size: 14px; color: #ba0c0c; }
        p a:hover { color: red; }
        table {
            border-collapse: collapse;
            width:500px;
            height:300px;
        }
        table, td, th {
            border: 1px solid black;
            text-align:center;
            padding:50px;
        }

      /*  .grid-container{

            width: 100%;
            max-width: 1200px;
        }


        .row:before,
        .row:after {
            content:"";
            display: table ;
            clear:both;
        }

        [class*='col-'] {
            float: left;
            min-height: 1px;
            width: 16.66%;

            padding: 12px;
            background-color: white;
        }

        .col-3{ width: 45%;    }
*/




    </STYLE>

    <body style="background-size:100% 100%;background-color:white ; position:absolute">

      <div class="container">
        <div class="row">
            <div class=" col-xs-6 col-sm-6 " style="background-color: white;box-shadow:
         inset 1px -1px 1px #444, inset -1px 1px 1px #444;">
                <p style="position:relative;text-align:center;top:50px"><i class="fa fa-user fa-5x "></i></p>
                <div ><p style="position:relative;text-align:center;font-size:40px;top:20px"><?php echo get_option('spark_search_user_copy_right') ?></p></div>
                <br/>
                <br/>
            </div>
            <div id="mokuai"  style="background-color: white position:relative; left:560px;width:150px; height:50px">

                <a class="red"><?php draw1()?></a>
                <a class="red"><?php draw2()?></a>
                <a class="red"><?php draw3()?></a>
                <a class="yellow"><?php draw4()?></a>
                <a class="yellow"><?php draw5()?></a>
                <a class="yellow"><?php draw6()?></a>
                <a class="blue"><?php draw7()?></a>
                <a class="blue"><?php draw8()?></a>
                <a class="blue"><?php draw9()?></a>
                <a class="blue"><?php draw10()?></a>


            </div>
        </div>
        <div class="row">

                    <div  class="col-md-6 col-xs-6 col-sm-6" style="background-color: white;
               box-shadow: inset 1px -1px 1px #444, inset -1px 1px 1px #444;">
                        <p>wiki</p>
                        <canvas width="583" height="400" id="sample"></canvas>
                    </div>
                    <div class="col-md-6 col-xs-6 col-sm-6 col-lg-6" style="background-color: white;box-shadow: inset 1px -1px 1px #444, inset -1px 1px 1px #444;">
                        <p>wiki内容喜好标签</p>

                    </div>
        </div>

        <div class="row">
                    <div class="col-md-6 col-xs-6 col-sm-6 col-lg-6" style="background-color: white;
               box-shadow: inset 1px -1px 1px #444, inset -1px 1px 1px #444;">


                        <p>wiki编辑创建词条数量统计表</p>
                        <table >
                            <tr>
                                <th></th>
                                <th>周</th>
                                <th>月</th>
                                <th>总计</th>
                            </tr>
                            <tr>
                                <td>编辑次数</td>
                                <td><?php edittimezhou()?></td>
                                <td><?php edittimemonth()?></td>
                                <td><?php editsum()?></td>
                            </tr>
                            <tr>
                                <td>创建次数</td>
                                <td><?php publishtimezhou()?></td>
                                <td><?php publishtimemonth()?></td>
                                <td><?php publishsum()?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6 col-xs-6 col-sm-6 col-lg-6" style="background-color: white;
               box-shadow: inset 1px -1px 1px #444, inset -1px 1px 1px #444;">
                        <p>wiki内容质量统计</p>
                        <table>
                            <tr>
                                <th>创建词条浏览量</th>
                                <th>发表评论</th>
                            </tr>
                            <tr>
                                <td>最高浏览量：<?php  wikiviewmost()?></td>
                                <td>发表评论总数：<?php  commentpost()?></td>
                            </tr>
                            <tr>
                                <td>平均浏览量: <?php wikiviewaverage()?></td>
                                <td>接收到的评论数: <?php getcomment()?></td>
                            </tr>
                        </table>
                    </div>
        </div>
      <div class="row">

          <div  class="col-md-6 col-xs-6 col-sm-6" style="background-color: white;
               box-shadow: inset 1px -1px 1px #444, inset -1px 1px 1px #444;">
              <p>问答</p>

              <canvas width="583" height="400" id="question"></canvas>
          </div>
          <div  class="col-md-6 col-xs-6 col-sm-6" style="background-color: white;
               box-shadow: inset 1px -1px 1px #444, inset -1px 1px 1px #444;">
              <p>问答内容喜好标签</p>

          </div>
      </div>
      <div class="row">

          <div  class="col-md-6 col-xs-6 col-sm-6" style="background-color: white;
               box-shadow: inset 1px -1px 1px #444, inset -1px 1px 1px #444;">
              <p>问答数量统计表</p>
              <table>
                  <tr>
                      <th></th>
                      <th>周</th>
                      <th>月</th>
                      <th>总计</th>
                  </tr>
                  <tr>
                      <td>提问次数</td>
                      <td><?php questiontimezhou()?></td>
                      <td><?php questiontimemonth()?></td>
                      <td><?php questionsum()?></td>
                  </tr>
                  <tr>
                      <td>回答次数</td>
                      <td><?php answertimezhou()?></td>
                      <td><?php answertimemonth()?></td>
                      <td><?php answersum()?></td>
                  </tr>
              </table>
          </div>
          <div class="col-md-6 col-xs-6 col-sm-6" style="background-color: white;">

              <p>问答质量统计</p>
              <table>
                  <tr>
                      <th>问题浏览量</th>
                      <th>回答统计</th>
                  </tr>
                  <tr>
                      <td>最高浏览量：<?php  questionviewmost()?></td>
                      <td>被采纳个数：<?php  getchoice()?></td>
                  </tr>
                  <tr>
                      <td>平均浏览量: <?php questionviewaverage()?></td>
                      <td>收获赞同数: <?php getzan()?> </td>
                  </tr>
              </table>
          </div>
      </div>

    </div>

  <!-- <div class="grid-container outline">

       <div class="row">
           <div class="col-3">
               <p style="position:relative;text-align:center;top:50px"><i class="fa fa-user fa-5x "></i></p>
               <div ><p style="position:relative;text-align:center;font-size:40px;top:20px"><?php echo get_option('spark_search_user_copy_right') ?></p></div>
               <br/>
               <br/>
           </div>
           <div class="col-3">
               <div id="mokuai"  style="background-color: white">

                   <a class="red"><?php draw1()?></a>
                   <a class="red"><?php draw2()?></a>
                   <a class="red"><?php draw3()?></a>
                   <a class="yellow"><?php draw4()?></a>
                   <a class="yellow"><?php draw5()?></a>
                   <a class="yellow"><?php draw6()?></a>
                   <a class="blue"><?php draw7()?></a>
                   <a class="blue"><?php draw8()?></a>
                   <a class="blue"><?php draw9()?></a>
                   <a class="blue"><?php draw10()?></a>

               </div>
           </div>
       </div>
       <div class="row">
           <div class="col-3">
               <p>wiki</p>
               <canvas width="583" height="400" id="sample"></canvas>
           </div>
           <div class="col-3">
               <p>wiki内容喜好标签</p>

               </div>
       </div>
       <div class="row">
           <div class="col-3">
               <p>wiki编辑创建词条数量统计表</p>
               <table>
                   <tr>
                       <th></th>
                       <th>周</th>
                       <th>月</th>
                       <th>总计</th>
                   </tr>
                   <tr>
                       <td>编辑次数</td>
                       <td><?php edittimezhou()?></td>
                       <td><?php edittimemonth()?></td>
                       <td><?php editsum()?></td>
                   </tr>
                   <tr>
                       <td>创建次数</td>
                       <td><?php publishtimezhou()?></td>
                       <td><?php publishtimemonth()?></td>
                       <td><?php publishsum()?></td>
                   </tr>
               </table>
           </div>
           <div class="col-3">
               <p>wiki内容质量统计</p>
               <table>
                   <tr>
                       <th>创建词条浏览量</th>
                       <th>发表评论</th>
                   </tr>
                   <tr>
                       <td>最高浏览量：<?php  wikiviewmost()?></td>
                       <td>发表评论总数：<?php  commentpost()?></td>
                   </tr>
                   <tr>
                       <td>平均浏览量: <?php wikiviewaverage()?></td>
                       <td>接收到的评论数: <?php getcomment()?></td>
                   </tr>
               </table>

           </div>
       </div>
       <div class="row">
           <div class="col-3">
               <p>问答</p>

               <canvas width="583" height="400" id="question"></canvas>
           </div>
           <div class="col-3">
               <p>问答内容喜好标签</p>

           </div>
       </div>
       <div class="row">
           <div class="col-3">
               <p>问答数量统计表</p>
               <table>
                   <tr>
                       <th></th>
                       <th>周</th>
                       <th>月</th>
                       <th>总计</th>
                   </tr>
                   <tr>
                       <td>提问次数</td>
                       <td><?php questiontimezhou()?></td>
                       <td><?php questiontimemonth()?></td>
                       <td><?php questionsum()?></td>
                   </tr>
                   <tr>
                       <td>回答次数</td>
                       <td><?php answertimezhou()?></td>
                       <td><?php answertimemonth()?></td>
                       <td><?php answersum()?></td>
                   </tr>
               </table>
           </div>
           <div class="col-3">
               <p>问答质量统计</p>
               <table>
                   <tr>
                       <th>问题浏览量</th>
                       <th>回答统计</th>
                   </tr>
                   <tr>
                       <td>最高浏览量：<?php  questionviewmost()?></td>
                       <td>被采纳个数：<?php  getchoice()?></td>
                   </tr>
                   <tr>
                       <td>平均浏览量: <?php questionviewaverage()?></td>
                       <td>收获赞同数: <?php getzan()?> </td>
                   </tr>
               </table>
           </div>
       </div>
           </div>

-->
    </body>
    </html>
    <?php

}

@extends('layouts.evento')

@section('content')
    <style>
        .tagNameCircle{
            width: 17px;
            height: 17px;
            margin-right: 5px;
            border-radius: 100%;
        }
    </style>
    <div class="container">
        <div class="row">
            <div class="col-md-2" style="align-self: center;">
                <div class="container">
                    <script> var tagData = []; </script>

                    <h5>Tag count: {{ count($eventoTagResult) }}</h5>
                    @foreach($eventoTagResult as $k => $v)
                    <script>
                        tagData.push( [ '{{$v['tag_name']}}', {{$v['tag_value']}}, '{{$v['tag_color']}}' ])
                    </script>
                    @endforeach

                    <div id="myLegend"></div>
                </div>
            </div>
            <div class="col-md-10">
                <div class="container">
                    <canvas id="pieDiagrammCanvas"></canvas>
                </div>
            </div>
        </div>
    </div>
@push('footer_js')
<script>
var myCanvas = document.getElementById("pieDiagrammCanvas");
myCanvas.width = 250;
myCanvas.height = 250;

var ctx = myCanvas.getContext("2d");

var tagValues = {
    "BeeLine": 15640,
    "Megafon": 5350,
    "Rostelecom":4700,
    "доход": 16600,
    "расход": 34800,
};
var tagColors = ['#36c417', '#f6c417', '#7800ff', '#5CB85C', '#D9534F',];

tagValues = {};
tagColors = [];

if (tagData.length){
    for(let i=0; i<tagData.length; i++){
        var tagName = tagData[i][0];
        var tagValue = tagData[i][1];
        tagValues[tagName] = tagValue;
        tagColors.push(tagData[i][2]);
    }
}
//console.log(tagData);
//console.log(tagValues);
//console.log(tagColors);

function drawLine(ctx, startX, startY, endX, endY){
    ctx.beginPath();
    ctx.moveTo(startX,startY);
    ctx.lineTo(endX,endY);
    ctx.stroke();
}

function drawArc(ctx, centerX, centerY, radius, startAngle, endAngle){
    ctx.beginPath();
    ctx.arc(centerX, centerY, radius, startAngle, endAngle);
    ctx.stroke();
}

function drawPieSlice(ctx,centerX, centerY, radius, startAngle, endAngle, color ){
    ctx.fillStyle = color;
    ctx.beginPath();
    ctx.moveTo(centerX,centerY);
    ctx.arc(centerX, centerY, radius, startAngle, endAngle);
    ctx.closePath();
    ctx.fill();
}

var Piechart = function(options){
    this.options = options;
    this.canvas = options.canvas;
    this.ctx = this.canvas.getContext("2d");
    this.colors = options.colors;

    this.draw = function(){
        var total_value = 0;
        var color_index = 0;
        for (var categ in this.options.data){
            var val = this.options.data[categ];
            total_value += val;
        }

        var start_angle = 0;
        for (categ in this.options.data){
            val = this.options.data[categ];
            var slice_angle = 2 * Math.PI * val / total_value;

            drawPieSlice(
                this.ctx,
                this.canvas.width/2,
                this.canvas.height/2,
                Math.min(this.canvas.width/2,this.canvas.height/2),
                start_angle,
                start_angle+slice_angle,
                this.colors[color_index%this.colors.length]
            );

            start_angle += slice_angle;
            color_index++;
        }

        if (this.options.doughnutHoleSize){
            drawPieSlice(
                this.ctx,
                this.canvas.width/2,
                this.canvas.height/2,
                this.options.doughnutHoleSize * Math.min(this.canvas.width/2,this.canvas.height/2),
                0,
                2 * Math.PI,
                "#ffffff"
            );
        }

        start_angle = 0;
        for (categ in this.options.data){
            val = this.options.data[categ];
            slice_angle = 2 * Math.PI * val / total_value;
            var pieRadius = Math.min(this.canvas.width/2,this.canvas.height/2);
            var labelX = this.canvas.width/2 + (pieRadius / 2) * Math.cos(start_angle + slice_angle/2);
            var labelY = this.canvas.height/2 + (pieRadius / 2) * Math.sin(start_angle + slice_angle/2);

            if (this.options.doughnutHoleSize){
                var offset = (pieRadius * this.options.doughnutHoleSize ) / 2;
                labelX = this.canvas.width/2 + (offset + pieRadius / 2) * Math.cos(start_angle + slice_angle/2);
                labelY = this.canvas.height/2 + (offset + pieRadius / 2) * Math.sin(start_angle + slice_angle/2);
            }

            var labelText = Math.round(100 * val / total_value);
            this.ctx.fillStyle = "white";
            this.ctx.font = "bold 15px Arial";
            this.ctx.fillText(labelText+"%", labelX,labelY);
            start_angle += slice_angle;
        }

        if (this.options.legend){
            color_index = 0;
            var legendHTML = "";``
            for (categ in this.options.data){
                legendHTML += "<div style='display: flex; align-items: center;'>" +
                    "<span class='tagNameCircle' style='background-color:"+this.colors[color_index++]+";'>" +
                    "&nbsp;</span> <span>"+categ+"</span> </div>";
            }
            this.options.legend.innerHTML = legendHTML;
        }
    }
}

//drawLine(ctx,100,100,200,200);
//drawArc(ctx, 150,150,150, 0, Math.PI/3);
//drawPieSlice(ctx, 150,150,150, Math.PI/2, Math.PI/2 + Math.PI/4, '#ff0000');

var tagValuesDiagramm = new Piechart({
    canvas: myCanvas,
    data: tagValues,
    colors: tagColors,
    legend: myLegend,
    //doughnutHoleSize:0.5,
});
tagValuesDiagramm.draw();
</script>
@endpush

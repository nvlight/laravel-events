<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gistogramm js</title>
</head>
<body>
    <canvas id="js_gistogramm_month"></canvas>
    <legend for="js_gistogramm_month"></legend>
    <script>
        let canvas = document.getElementById("js_gistogramm_month");
        canvas.width = 300;
        canvas.height = 300;

        let ctx = canvas.getContext("2d");

        function drawLine(ctx, startX, startY, endX, endY,color){
            ctx.save();
            ctx.strokeStyle = color;
            ctx.beginPath();
            ctx.moveTo(startX,startY);
            ctx.lineTo(endX,endY);
            ctx.stroke();
            ctx.restore();
        }

        function drawBar(ctx, upperLeftCornerX, upperLeftCornerY, width, height,color){
            ctx.save();
            ctx.fillStyle=color;
            ctx.fillRect(upperLeftCornerX,upperLeftCornerY,width,height);
            ctx.restore();
        }

        let Barchart = function(options){
            this.options = options;
            this.canvas = options.canvas;
            this.ctx = this.canvas.getContext("2d");
            this.colors = options.colors;

            this.draw = function(){
                var maxValue = 0;
                for (var categ in this.options.data){
                    maxValue = Math.max(maxValue,this.options.data[categ]);
                }
                var canvasActualHeight = this.canvas.height - this.options.padding * 2;
                var canvasActualWidth = this.canvas.width - this.options.padding * 2;

                //drawing the grid lines
                // var gridValue = 0;
                // while (gridValue <= maxValue){
                //     var gridY = canvasActualHeight * (1 - gridValue/maxValue) + this.options.padding;
                //     drawLine(
                //         this.ctx,
                //         0,
                //         gridY,
                //         this.canvas.width,
                //         gridY,
                //         this.options.gridColor
                //     );
                //
                //     //writing grid markers
                //     this.ctx.save();
                //     this.ctx.fillStyle = this.options.gridColor;
                //     this.ctx.font = "bold 10px Arial";
                //     this.ctx.fillText(gridValue, 10,gridY - 2);
                //     this.ctx.restore();
                //
                //     gridValue+=this.options.gridScale;
                // }

                //drawing the bars
                var barIndex = 0;
                var numberOfBars = Object.keys(this.options.data).length;
                var barSize = (canvasActualWidth)/numberOfBars;

                for (categ in this.options.data){
                    var val = this.options.data[categ];
                    var barHeight = Math.round( canvasActualHeight * val/maxValue) ;
                    drawBar(
                        this.ctx,
                        this.options.padding + barIndex * barSize,
                        this.canvas.height - barHeight - this.options.padding,
                        barSize,
                        barHeight,
                        this.colors[barIndex%this.colors.length]
                    );

                    //draw bar value
                    this.ctx.save();
                    this.ctx.fillStyle = this.options.gridColor;
                    this.ctx.font = "bold 11px Arial";
                    this.ctx.fillText(val,
                        this.options.padding + (barIndex * barSize + barSize/2 - barSize.toString().length*3),
                        this.canvas.height - barHeight - this.options.padding - 5);
                    this.ctx.restore();

                    barIndex++;
                }

                //drawing series name
                this.ctx.save();
                this.ctx.textBaseline="bottom";
                this.ctx.textAlign="center";
                this.ctx.fillStyle = "#000000";
                this.ctx.font = "bold 14px Arial";
                this.ctx.fillText(this.options.seriesName, this.canvas.width/2,this.canvas.height);
                this.ctx.restore();

                //draw legend
                barIndex = 0;
                //let legend = document.querySelector("legend[for="+`'${this.canvas_id}'`+"]");
                let legend = document.querySelector("legend[for='js_gistogramm_month']");
                console.log(legend);
                if (legend){
                    var ul = document.createElement("ul");
                    legend.append(ul);
                    for (categ in this.options.data){
                        var li = document.createElement("li");
                        li.style.listStyle = "none";
                        li.style.borderLeft = "20px solid "+this.colors[barIndex%this.colors.length];
                        li.style.padding = "5px";
                        li.textContent = categ;
                        ul.append(li);
                        barIndex++;
                    }
                }
            }
        }

        var tagValues = {
            "dohodi": 25000,
            "rashodi": 15000,
            "Internet": 2000,
            "Svet/Elektro": 3000
        };

        var tagValuesChart = new Barchart(
            {
                seriesName:"Tag Values - current month",
                canvas:canvas,
                canvas_id:'js_gistogramm_month',
                padding:15,
                gridScale:5,
                gridColor:"#000",
                data:tagValues,
                colors:["#a55ca5","#67b6c7", "#bccd7a","#eb9743"]
            }
        );
        tagValuesChart.draw();

    </script>

</body>
</html>
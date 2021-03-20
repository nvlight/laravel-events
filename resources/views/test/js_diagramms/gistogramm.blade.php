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
    <div class="canvas_wrapper" style="width: 100%;">
        <canvas id="js_gistogramm_month"></canvas>
    </div>

    <legend for="js_gistogramm_month"></legend>
    <script>
        let canvas = document.getElementById("js_gistogramm_month");
        canvas.width = 700;
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

                let numberOfBars = 0;
                let numberOfGroups = 0;
                let maxValue = 0;
                for (let i in this.options.data) {
                    for (let j in this.options.data[i]) {
                        maxValue = Math.max(maxValue, this.options.data[i][j]['value']);
                        numberOfBars++;
                    }
                    numberOfGroups++;
                }
                //console.log('maxValue: '+maxValue);

                let canvasActualHeight = this.canvas.height - this.options.padding * 2;
                let canvasActualWidth = this.canvas.width - this.options.padding * 2;

                //drawing the grid lines
                // let gridValue = 0;
                // while (gridValue <= maxValue){
                //     let gridY = canvasActualHeight * (1 - gridValue/maxValue) + this.options.padding;
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
                let barIndex = 0;
                let barOffset = 10;
                let barSize = (canvasActualWidth)/ (numberOfBars + numberOfGroups - 1);

                let offset = 0; //for
                for (let i in this.options.data){

                    let val0 = this.options.data[i];

                    let firstOffset = 0;
                    for (let j in val0){

                        if (!firstOffset){
                            firstOffset++;

                            // draw month title
                            this.ctx.save();
                            this.ctx.fillStyle = this.options.gridColor;
                            this.ctx.font = "bold 11px Arial";
                            this.ctx.fillText(i,
                                this.options.padding + (barIndex * barSize) + offset,
                                this.canvas.height - this.options.padding + 11);
                            this.ctx.restore();
                        }

                        let val   = val0[j]['value'];
                        let color = val0[j]['color'];

                        let barHeight = Math.round( canvasActualHeight * val/maxValue);
                        drawBar(
                            this.ctx,
                            this.options.padding + barIndex * barSize + offset,
                            this.canvas.height - barHeight - this.options.padding,
                            barSize,
                            barHeight,
                            color,
                        );

                        //draw bar value
                        this.ctx.save();
                        this.ctx.fillStyle = this.options.gridColor;
                        this.ctx.font = "bold 11px Arial";
                        this.ctx.fillText(val,
                            //this.options.padding + (barIndex * barSize + barSize/2 - val.toString().length*2 ) + offset,
                            this.options.padding + (barIndex * barSize + 3) + offset,
                            this.canvas.height - barHeight - this.options.padding - 5);
                        this.ctx.restore();
                        barIndex++;

                    }

                    offset += barOffset;
                }

                //drawing series name
                // this.ctx.save();
                // this.ctx.textBaseline="bottom";
                // this.ctx.textAlign="center";
                // this.ctx.fillStyle = "#000000";
                // this.ctx.font = "bold 14px Arial";
                // this.ctx.fillText(this.options.seriesName, this.canvas.width/2,this.canvas.height);
                // this.ctx.restore();

                //draw legend
                let legend = document.querySelector("legend[for='js_gistogramm_month']");
                if (legend){
                    let ul = document.createElement("ul");
                    legend.append(ul);

                    let columnNames = {};
                    let columnColors = {};
                    for (let i in this.options.data){
                        for (let j in this.options.data[i]){
                            let vl = this.options.data[i][j];

                            if (!columnNames[j]){
                                columnNames[j] = vl['value'];
                            }else{
                                columnNames[j] += vl['value'];
                            }

                            if (!columnColors[j]){
                                columnColors[j] = vl['color'];
                            }
                        }
                    }
                    //console.log(columnNames);
                    //console.log(columnColors);

                    barIndex = 0;
                    for (let i in columnNames){
                        let li = document.createElement("li");
                        li.style.listStyle = "none";
                        li.style.borderLeft = "20px solid "+columnColors[i];
                        li.style.padding = "5px";
                        li.textContent = i + ` (${columnNames[i]})`;
                        ul.append(li);
                        barIndex++;
                    }
                }

            }
        }

        let tagValues = {
            'january' : {
                "dohodi": { 'value' : 25000, 'color': "#a55ca5", },
                "rashodi": { 'value' : 15000, 'color': "#67b6c7", },
                "Internet": { 'value' : 2100, 'color': "#bccd7a", },
                "Svet/Elektro": { 'value' : 1000, 'color': "#eb9743", },
            },
            'february' : {
                "dohodi": { 'value' : 33000, 'color': "#a55ca5", },
                "rashodi": { 'value' : 19000, 'color': "#67b6c7", },
                "Internet": { 'value' : 2100, 'color': "#bccd7a", },
                "Svet/Elektro": { 'value' : 2300, 'color': "#eb9743", },
            },
            'march' : {
                "dohodi": { 'value' : 15000, 'color': "#a55ca5", },
                "rashodi": { 'value' : 29000, 'color': "#67b6c7", },
                "Internet": { 'value' : 2500, 'color': "#bccd7a", },
                "Svet/Elektro": { 'value' : 1100, 'color': "#eb9743", },
            },
            'april' : {
                "dohodi": { 'value' : 17000, 'color': "#a55ca5", },
                "rashodi": { 'value' : 12000, 'color': "#67b6c7", },
                "Internet": { 'value' : 2100, 'color': "#bccd7a", },
                "Svet/Elektro": { 'value' : 1500, 'color': "#eb9743", },
            },
        };

        let tagValuesChart = new Barchart(
            {
                seriesName:"Tag Values - current month",
                canvas:canvas,
                canvas_id:'js_gistogramm_month',
                padding:15,
                gridScale:5,
                gridColor:"#000",
                data:tagValues,
            }
        );
        tagValuesChart.draw();

    </script>

</body>
</html>
<x-tenant-layout title="{{ __('Dashboard') }}" :themeAction="$themeAction">
    <div class="container-fluid">
        <div class="row">
            {{-- <div class="container-fluid"> --}}
                <!-- Add Order -->
                <div class="modal fade" id="addOrderModalside">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title">Add Event</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <form>
                          <div class="form-group">
                            <label class="text-black font-w500">Event Name</label>
                            <input type="text" class="form-control">
                          </div>
                          <div class="form-group">
                            <label class="text-black font-w500">Event Date</label>
                            <input type="date" class="form-control">
                          </div>
                          <div class="form-group">
                            <label class="text-black font-w500">Description</label>
                            <input type="text" class="form-control">
                          </div>
                          <div class="form-group">
                            <button type="button" class="btn btn-primary">Create</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
                
                <!-- row -->
                
                @livewire('tenant.dashboard.show')

                <div class="modal fade" id="modalInfo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Informação Tarefa</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                       
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                      </div>
                    </div>
                  </div>
                </div>
                
              {{-- </div> --}}
        </div>
    </div>
</x-tenant-layout>

{{-- @push('custom-scripts') --}}
<script>

/* Grafico dos meses por linha*/
 var monthsValues = JSON.parse(jQuery("#arrayGraph").val());

 var arrayMonthsValues = jQuery.map(monthsValues, function(value, index){
         return [value];
 });
 /***********/

 /* Grafico dos meses por grafico barra */
//   var monthsGraphBar = JSON.parse(jQuery("#arrayColumnGraph").val());

//   var arrayMonthsGraphBar = jQuery.map(monthsGraphBar, function(value, index){
// 		console.log(index);
//   });

var values = [];
var colors = [];


window.addEventListener('updateGraph',function(e){
  jQuery("#donutChartt").empty();
  
  jQuery("#revenue").empty();
 

  if(e.detail.function == "muda")
  {
     jQuery("#selectMonth").val("4").change();
	 jQuery("#selectMonthGraph").val(new Date().getFullYear()).change();
  }
  else if(e.detail.function == "monthMudou")
  {
	jQuery("#selectMonthGraph").val(new Date().getFullYear()).change();
  }
  


  values = [];
  colors = [];

  monthsValues = JSON.parse(jQuery("#arrayGraph").val());

 arrayMonthsValues = jQuery.map(monthsValues, function(value, index){
         return [value];
 });

  
  var numberOfCustomers = jQuery("#numberOfCustomers").val();

    for(i=1;i<=numberOfCustomers;i++)
    {
       values.push(jQuery("#testeID"+i).attr("data-value"));
       colors.push(jQuery("#testeID"+i).attr("data-color"));
    }

  setTimeout(function(){
			dzChartlist.load();
		}, 1000); 

});


var dzChartlist = function(){
 
	let draw = Chart.controllers.line.__super__.draw; //draw shadow
	var screenWidth = jQuery(window).width();
	var donutChart = function(){
  
    var valuesCommaRemoved = values.join(','); 
    
		var options = {
          series: valuesCommaRemoved.split(',').map(Number),
          chart: {
          type: 'donut',
        },
		  legend:{
			show:false  
		  },
		  plotOptions: {
			 pie: {
				startAngle: -86,
				donut: {
					 size: '40%',
				}
			 },
		  },
		  stroke:{
			width:'10'  
		  },
		  dataLabels: {
			  formatter(val, opts) {
				const name = opts.w.globals.labels[opts.seriesIndex]
				return [ val.toFixed() + '%']
			  },
			  dropShadow: {
                enabled: false
              },
			  style: {
                fontSize: '15px',
                colors: ["#fff"],
              }
			},
		  colors: colors,
      tooltip: {
   
  }

  };

        var chart = new ApexCharts(document.querySelector("#donutChartt"), options);
        chart.render();
	}
  var revenueChart = function(){
		var revenue = document.getElementById("revenue");
			if (revenue !== null) {
				var activityData = [
					{
						first: [35, 40, 30, 38, 32, 42, 30, 35, 22, 30, 45, 40]
					}
				];
				revenue.height = 300;
				
				var config = {
					type: "line",
					data: {
						labels: [
							"Janeiro",
							"Fevereiro",
							"Março",
							"Abril",
							"Maio",
							"Junho",
							"Julho",
							"Agosto",
							"Setembro",
							"Outubro",
							"Novembro",
							"Dezembro",
						],
						datasets: [
							{
								label: "My First dataset",
								data:  arrayMonthsValues,
								borderColor: 'rgba(0, 126, 236, 0.8)',
								borderWidth: "8",
								backgroundColor: 'rgba(152, 205, 251, 0.8)'
								
							}
						]
					},
					options: {
						responsive: true,
						maintainAspectRatio: false,
						elements: {
								point:{
									radius: 0
								}
						},
						legend:false,
						
						scales: {
							yAxes: [{
								gridLines: {
									color: "rgba(89, 59, 219,0.1)",
									drawBorder: true
								},
								ticks: {
									fontColor: "#999",
								},
							}],
							xAxes: [{
								gridLines: {
									display: false,
									zeroLineColor: "transparent"
								},
								ticks: {
									stepSize: 5,
									fontColor: "#999",
									fontFamily: "Nunito, sans-serif"
								}
							}]
						},
						tooltips: {
							enabled: false,
							mode: "index",
							intersect: false,
							titleFontColor: "#888",
							bodyFontColor: "#555",
							titleFontSize: 12,
							bodyFontSize: 15,
							backgroundColor: "rgba(256,256,256,0.95)",
							displayColors: true,
							xPadding: 10,
							yPadding: 7,
							borderColor: "rgba(220, 220, 220, 0.9)",
							borderWidth: 2,
							caretSize: 6,
							caretPadding: 10
						}
                   
					}
				};

				var ctx = document.getElementById("revenue").getContext("2d");

				var myLine = new Chart(ctx, config);

				var items = document.querySelectorAll("#sales-revenue .nav-tabs .nav-item");
	
				items.forEach(function(item, index) {
					item.addEventListener("click", function() {
						config.data.datasets[0].data = activityData[index].first;
						myLine.update();
					});
				});

			}

	}


	/* Function ============ */
		return {
			init:function(){
			},
			
			
			load:function(){
				donutChart();
        		revenueChart();
			},
			
			resize:function(){
				
			}
		}
	
	}();


  

  jQuery(document).ready(function(){

    var numberOfCustomers = jQuery("#numberOfCustomers").val();

	jQuery("#selectMonth").val("4").change();

	jQuery("#selectMonthGraph").val(new Date().getFullYear()).change();

    for(i=1;i<=numberOfCustomers;i++)
    {
       values.push(jQuery("#testeID"+i).attr("data-value"));
       colors.push(jQuery("#testeID"+i).attr("data-color"));
    }
   
	});
		
	jQuery(window).on('load',function(){
		setTimeout(function(){
			dzChartlist.load();
		}, 1000); 
		
	});
 
 
   
    
</script>   
{{-- @endpush --}}

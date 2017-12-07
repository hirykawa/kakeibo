<div class="row">
    <div class="col-sm-2">
        <h5 class="glyphicon glyphicon-arrow-left text-center"></h5>
    </div>
    <div class="col-sm-8">
        <h5 class="text-center">{{date('n')}}月の合計収支</h5>
    </div>
    <div class="col-sm-2">
        <h5 class="glyphicon glyphicon-arrow-right text-right text-center"></h5>
    </div>
</div>
@if($bop['outcome'] == 0 && $bop['can_use'] == 0)
    <p class="text-center" style="margin-top: 20%;margin-bottom: 20%">今月の収支がまだ登録されてません</p>
@else
    <canvas id="inoutChart"></canvas>
@endif
<h6 class="text-center">今月は残り<span style="color: #c0392b;">{{$bop['can_use']}}</span>円使えます</h6>

<script>
            @if($bop['outcome'] != 0 || $bop['can_use'] != 0)
    var ctx = document.getElementById('inoutChart').getContext('2d');
    var inoutChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['支出', 'つかえるお金'],
            datasets: [{
                backgroundColor: [
                    "#E74C3C",
                    "#3498DB"
                ],
                data: [{{$bop['outcome']}}, {{$bop['can_use']}}]
            }]
        },
        options: {
            tooltips: {
                callbacks: {
                    label: function (tooltipItem, data) {
                        return data.labels[tooltipItem.index]
                            + ": "
                            + data.datasets[0].data[tooltipItem.index]
                            + " 円"; //ここで単位を付けます
                    }
                }
            }
        }
    });
    @endif
</script>
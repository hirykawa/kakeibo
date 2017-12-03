@extends('layouts.app')
@section('title', '使いやすい家計簿')
@section('content')


<div class="row">
    <div class = "col-md-5">
        {{$message}}
    </div>
  <div class = "col-md-offset-1 col-md-2">
    <a href="/list" class="btn btn-lg btn-success btn-block" type="button">My家計簿を見る</a>
  </div>
  <div class = "col-md-2">
    <a href="/income" class="btn btn-lg btn-warning btn-block" type="button">収入を追加する</a>
  </div>
  <div class = "col-md-2">
    <a href="/logout" class="btn btn-lg btn-danger btn-block" type="button">ログアウト</a>
  </div>
</div>
<div class="row" style="margin-top: 50px">
  <div class="col-sm-4">
    <h5 class="text-center">{{date('n')}}月の合計収支</h5>
    <canvas id="inoutChart"></canvas>
      <h6 class="text-center">今月は残り<span style="color: #c0392b;">{{$bop['can_use']}}</span>円使えます</h6>
  </div>
  <div class="col-sm-4">
    <form class="form-signin" role="form" method="post" action="">
      <div class="form-group">
        <h4>簡単入力レシート</h4>
        {{-- CSRF対策 --}}
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <div class="form-inline" style="margin-top: 10px">
          <label for="tag_name">種類　　：</label>
          <select style="width: 170px" class="form-control form-margin" id="tag_name" name="title" required autofocus>
              <option value="1">食費</option>
              <option value="2">生活費(日用品)</option>
              <option value="3">趣味・交際</option>
              <option value="4">交通費</option>
              <option value="5">家賃・水光熱・通信</option>
              <option value="6" selected="selected">その他</option>
          </select>
        </div>
        <div class="form-inline">
        <label for="tag_price">価格　　：</label>
        <input type="text" name="price" id="tag_price" class="form-control form-margin" data-format="$1 円" pattern="^[1-9][0-9]*$" placeholder="値段を入力" required>  円
        </div>
        <div class="form-inline">
          <label for="tag_days">購入日付：</label>
        <input type="date" name="purchased_at" id="tag_days" class="form-control form-margin" value ="@php echo date('Y-m-j'); @endphp" required>
        </div>
        <div class="form-inline">
          <label for="tag_name">詳細　　：</label>
          <input type="text" name="detail" id="tag_detail" class="form-control form-margin" placeholder="備考があれば入力してください">
        </div>
        <div class="form-inline">
          <label for="tag_name">必要　　：</label>
          <input type="checkbox" name="needs" id="tag_needs" value="1" class="form-control form-margin">
        </div>
        <div class="row" style="margin-top: 20px ;margin-left: auto;margin-right: auto;">
          <button class="btn btn-lg btn-primary" type="submit">送信</button>
        </div>
      </div>
    </form>
    </form>
  </div>
  <div class="col-sm-4">
      <h5 class="text-center">{{date('n')}}月の支出分布</h5>
      <canvas id="outcomeChart"></canvas>
      <h6 class="text-center">一番多い出費は<span style="color: #c0392b;">{{config('out_title.'.$outcome['max_key'])}}</span>です</h6>
  </div>
</div>
<div class="row">
    <div class="col-sm-4">
        <h4>今月の無駄遣い率</h4>
        <h6>支出額の<span style="color: #c0392b;">{{$need['parsent']}}%</span>は無駄な出費です</h6>
        <h6>{{$need['need_outcome_count']+$need['not_need_outcome_count']}}件のうち{{$need['not_need_outcome_count']}}件の出費は無駄です</h6>
    </div>
    <div class="col-sm-8">
        <h4>今週の支出推移グラフ</h4>
        <canvas id="line_chart" style="width:100%;height: auto;"></canvas>
    </div>
</div>

<script>
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
    var occ = document.getElementById('outcomeChart').getContext('2d');
    var outcomeChart = new Chart(occ, {
        type: 'pie',
        data: {
            labels: ['食費', '生活費', '趣味・交際費', '交通費', '家賃・水光熱費・通信', 'その他'],
            datasets: [{
                backgroundColor: [
                    "#E74C3C",
                    "#3498DB",
                    '#e67e22',
                    '#9b59b6',
                    '#1abc9c',
                    '#95a5a6'
                ],
                data: [{{$outcome[1]}}, {{$outcome[2]}}, {{$outcome[3]}}, {{$outcome[4]}}, {{$outcome[5]}}, {{$outcome[6]}}]
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
    //3つめ
    var line = document.getElementById("line_chart").getContext('2d');
    var line_chart = new Chart(line, {
        type: 'line',
        data: {
            labels: [
                @foreach($week_outcome as $key => $value)
                "{{$key}}"
                ,
                @endforeach
            ],
            datasets: [{
                label: '支出',
                lineTension: 0,
                data: [
                    @foreach($week_outcome as $key => $value)
                    {{$value}}
                    ,
                    @endforeach
                ],
                borderColor: [
                    "#34495e"
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero:true
                    }
                }]
            },
            responsive:false
        }
    });
</script>
@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div id="fortuneDIV" class="col-md-10">
            @if (isset($fortune) && sizeof($fortune) > 0)
                <div class="row mt-2">
                    <h5 class="card-title mt-2">@{{`${date}-${fortune[index].name}`}}</h5>
                </div>
                <form>
                    <div class="form-group">
                        <label style="vertical-align: top;">@{{`整體運勢-${fortune[index].overallStar}星`}}</label>
                        <textarea disabled style="width: 100%;height: auto;">@{{fortune[index].overallText}}</textarea>
                    </div>
                    <div class="form-group">
                        <label style="vertical-align: top;">@{{`愛情運勢-${fortune[index].loveStar}星`}}</label>
                        <textarea disabled style="width: 100%;height: auto;">@{{fortune[index].loveText}}</textarea>
                    </div>
                    <div class="form-group">
                        <label style="vertical-align: top;">@{{`事業運勢-${fortune[index].careerStar}星`}}</label>
                        <textarea disabled style="width: 100%;height: auto;">@{{fortune[index].careerText}}</textarea>
                    </div>
                    <div class="form-group">
                        <label style="vertical-align: top;">@{{`財富運勢-${fortune[index].wealthStar}星`}}</label>
                        <textarea disabled style="width: 100%;height: auto;">@{{fortune[index].wealthText}}</textarea>
                    </div>
                </form>
                <div class="row mt-2">
                    <div class="col-sm-4"></div>
                    <div align="right" class="col-sm-1">
                        <button v-on:click="preFortune" type="button" class="btn btn-primary">&lt;</button>
                    </div>
                    <div align="center" class="col-sm-2"><span class="align-middle text-monospace">@{{ `${index + 1} / ${fortune.length}` }}</span></div>
                    <div align="lefht" class="col-sm-1">
                        <button v-on:click="nextFortune" type="button" class="btn btn-primary">&gt;</button>
                    </div>
                    <div class="col-sm-4"></div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('bottom_js')
    @if (isset($fortune))
        <script text="text/javascript">
            let fortuneDIV = new Vue({
                el: '#fortuneDIV',
                data: {
                    date: "<?php echo date("Y-m-d"); ?>",
                    fortune: JSON.parse('<?php echo json_encode($fortune); ?>'),
                    index: 0
                },
                methods: {
                    preFortune: function(){
                        if(this.index > 0)
                            this.index--;
                    },
                    nextFortune: function(){
                        if(this.index < this.fortune.length - 1)
                            this.index++;
                    }
                }
            });
            $(document).ready(() => {
            });
        </script>
    @endif
@endsection

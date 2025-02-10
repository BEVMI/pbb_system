@extends('layouts.table')

@section('main')
<div class="container-fluid" style="padding-left:0px; padding-right:0px;">
    <div class="row">
        <div class="col-12">
            <div class="table-responsive" style="height: 600px; overflow-x:auto;">
                <table class="table" id="irene_table">
                    <thead class="irene_thead">
                    <tr class="text-center">
                        <th style="width: 15%;">STOCKCODE</th>
                        <th style="width: 15%;">DESCRIPTION</th>
                        <th style="width: 15%;">LONGDESC</th>
                        <th style="width: 15%;">QTY</th>
                        <th style="width: 15%;">UNIT REQ.</th>
                        <th style="width: 15%;">ONHAND</th>
                    </tr>
                    </thead>
                    <tbody>
                        @if(!empty($mrps))
                            @foreach ($mrps as $mrp)
                                <tr class="bg-secondary text-center" style="color:white;" data-node="treetable-{{$mrp->id}}">
                                   <td>{{$mrp->stockCode}}</td>
                                   <td>{{$mrp->description}}</td>
                                   <td>{{$mrp->longDesc}}</td>
                                   <td>{{$mrp->qty}}</td>
                                   <td></td>
                                   <td></td>
                                </tr>
                                @foreach ($mrp->children as $row)
                                    <tr class="text-center" style="font-size:14px;" data-pnode="treetable-parent-{{$mrp->id}}">
                                        <td>-</td>
                                        <td>{{$row->cAlternateKey1}}</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>{{$row->unitRequired}}</td>
                                        <td>{{$row->onHand}}</td>
                                    </tr>
                                @endforeach
                            @endforeach
                        @endif
                    </tbody>
                </table>
                
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
     $(function() {
        $("#irene_table").treeFy({
            treeColumn: 0,
            collapseAnimateCallback: function(row) {
                row.fadeOut();
            },
            expandAnimateCallback: function(row) {
                row.fadeIn();
            },
            initStatusClass: 'treetable-collapsed'
        });
    });
</script>
@endsection
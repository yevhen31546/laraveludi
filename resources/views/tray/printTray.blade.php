
<style>
    div {
        font-weight:600;
        font-size:9px;
    }

    .header {
        text-align: center;
        padding-left: 5px;
        padding-right: 0px;
        width: 597px;
    }

    .header-date {
        float: right;
    }

    .header-company-name {
        float: left;
    }

    .line {
        display: flex;
    }

    .tray-container {
        height: 1.5in;
        width: 1.5in;
        border: 1.5px solid black;
        margin: 3px;
    }

    .nvm {
        margin: 3px;
        padding: 2px;
        padding-right:10px;
        border: 1.2px solid black;
    }

    .bound-wrapper {
        border: 1px solid black;
        padding: 1px;
        margin-right: 5px;
    }

    .chart {
        height: 20px;
        width: 20px
    }

    .sandclock {
        height: 20px;
        width: 15px;
    }
    .qr-td {
        vertical-align: baseline;
        position: absolute;
    }
    .qr {
        width:50px;
    }

    .expiredate span {
        padding-left: 5px;
    }

    .expiredate_ {
        padding-left:11px !important;
    }

    .company-name_ {
        padding-left: 11px;
    }

    .company-name {
        display: flex;
        align-items: center;
    }

</style>
{{--@php--}}
{{--dd($page_content);--}}
        {{--@endphp--}}
<div class="header">
    <span class="header-company-name">NUVASIVE,INC.</span>
    <span>TRAY {{ $other['tray_num'] }}</span>
    <span class="header-date">{{ date('Y-m-d') }}</span>
</div>

@php $new_line = 0; @endphp
@for($i=0; $i<count($page_content); $i++)

    @if($new_line % 2 === 0)
        <div class="line">
    @endif

    <div class="tray-container">
        <div class="nvm">
            <span>{{ $page_content[$i]['obj']['gudid']['device']['brandName'] }}</span>
            <br>
            <span>GTIN</span>{{ $sku_db[$i]['gtin'] }}
        </div>
        <table>
            <tr>
                <td rowspan="3">
                    <span class="bound-wrapper">UDI</span>
                </td>
                <td>(01){{ $sku_db[$i]['gtin'] }}</td>
            </tr>
            <tr>
                <td>(17){{ $sku_db[$i]['date'] }}</td>
            </tr>
            <tr>
                <td>(10){{ $sku_db[$i]['batch'] }}</td>
            </tr>
        </table>
        <table>
            <tr>
                <td>
                    <span class="bound-wrapper">LOT</span>
                    {{ $sku_db[$i]['batch'] }}
                </td>
                <td rowspan="3" class="qr-td"><img src="{{ url($page_content[$i]['qr_url']) }}" alt="QR" class="qr"></td>
            </tr>
            <tr>
                <td class="expiredate company-name">
        <span>
          <img src="{{ url('tray_img/sand-clock.png') }}" alt="sandclock" class="sandclock">
        </span>

                    <span class="expiredate_">{{ $sku_db[$i]['expirydate'] }}</span>
                </td>
            </tr>
            <tr>
                <td class="company-name">
        <span>
          <img src="{{ url('tray_img/chart.png') }}" alt="chart" class="chart">
        </span>
                    <span class="company-name_">{{ $page_content[$i]['obj']['gudid']['device']['companyName'] }}</span>
                </td>
            </tr>
        </table>
    </div>
    @if($new_line % 2 === 0)
        </div>
        @php $new_line = 0; @endphp
    @endif
    @php $new_line++; @endphp

@endfor
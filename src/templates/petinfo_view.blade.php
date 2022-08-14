<!DOCTYPE html>
<html lang="ja">

</html>

<head>
    <title>petinfo</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../static/css/pukiwiki.css">
</head>

<body>
    <hr class="full_hr">
    @foreach ($data_list as $data)
    <div class="contents">
        <a id="contents_1"></a>
        <ul class="list2 list-indent1">
            <li><a href="#{{ $data['Name'] }}">{{ $data['Name'] }}</a></li>
        </ul>
    </div>
    @endforeach
    <hr class="full_hr">

    @foreach ($data_list as $data)
    <h3 id="content_1_0">
        {{ $data['Name'] }}
        <a class="anchor_super" id="{{ $data['Name'] }}" href="#{{ $data['Name'] }}" style="user-select:none;">†</a>
    </h3>

    <table class="style_table" cellspacing="1" border="0">
        <tbody>
            <tr>
                <th class="style_th">設定可能なペット</th>
                <td class="style_td" colspan="3"><img src="../static/img/mobheads/{{ $data['MobTypes'] }}.png" width="32" height="32"> {{ $data['MobTypesJp'] }}</td>
            </tr>
            <tr>
                <th class="style_th">説明</th>
                <td class="style_td" colspan="3">{{ $data['Description'] }}</td>
            </tr>
            <tr>
                <th class="style_th">最高レベル</th>
                <td class="style_td" colspan="3">{{ $data['MaxLevel'] }}</td>
            </tr>
            <tr>
                <th class="style_th">飛行</th>
                <td class="style_td" colspan="3">{{ $data['CanFly'] }}</td>
            </tr>
            <tr>
                <th class="style_th">バックパック</th>
                <td class="style_td" colspan="3">{{ $data['Backpack'] }}</td>
            </tr>
            <tr>
                <th class="style_th" rowspan="100">ビーコン</th>
                <td class="style_td" colspan="3">{{ $data['Beacon'] }}</td>
            </tr>
            @if ($data['Beacon'] == 'あり')
            <tr>
                <th class="style_th">要求レベル、発動数、持続時間</th>
                <th class="style_th">効果</th>
                <th class="style_th">効果レベル</th>
            </tr>
                @foreach ($data['Beacon_details'] as $level => $ability)
                    @if (array_key_exists('Buffs', $ability))
            <tr>
                <td class="style_td" rowspan="{{ count($ability['Buffs']) }}">Lv: {{ $level }}<br>発動数: {{ $ability['Count'] }}<br>持続時間: {{ $ability['Duration'] }}秒</td>

                        @foreach ($ability['Buffs'] as $buff_name => $buff_value)
                <td class="style_td" rowspan="1"><img src="../static/img/beacon/{{ strtolower($buff_name) }}.png" width="32" height="32"> {{ $translate_beacon_buff[$buff_name] }}</td>
                <td class="style_td">{{ $buff_value === true ? '-' : $buff_value }}</td>
            </tr>
                        @endforeach
                    @endif
                @endforeach
            @endif
        </tbody>
    </table>
    @endforeach
</body>

</html>
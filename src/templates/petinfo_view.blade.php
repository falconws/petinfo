<!DOCTYPE html>
<html lang="ja">

</html>

<head>
    <title>petinfo</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../static/css/pukiwiki.css">
</head>

<body>
    @foreach ($data_list as $data)
    <h3 id="content_1_0">
        {{ $data['Name'] }}
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
                <th class="style_th">要求レベル、増分発動数、増分持続時間</th>
                <th class="style_th">効果</th>
                <th class="style_th">増分効果レベル</th>
            </tr>
            @foreach ($data['Beacon_details'] as $level => $spec)
            <tr>
                <td class="style_td" rowspan="{{ count($spec['Buffs']) }}">Lv: {{ $level }}<br>増分発動数: {{ $spec['Count'] }}<br>増分持続時間: {{ $spec['Duration'] }}秒</td>

                @foreach ($spec['Buffs'] as $buff_name => $buff_value)
                <td class="style_td" rowspan="1"><img src="../static/img/beacon/{{ $buff_name }}.png" width="32" height="32"> {{ $data_list['translate_beacon_buff'][$buff_name] }}</td>
                <td class="style_td">{{ $buff_value }}</td>
                @endforeach
            </tr>
            @endforeach
            @endif
        </tbody>
    </table>
    @endforeach
</body>

</html>
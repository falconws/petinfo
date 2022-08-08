<!DOCTYPE html>
<html lang="ja">

</html>

<head>
    <title>petinfo</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://toraden.com/wiki/skin/pukiwiki.css">
</head>

<body>
    <?php $__currentLoopData = $data_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <h3 id="content_1_0">
        <?php echo e($data['Name']); ?>

    </h3>

    <table class="style_table" cellspacing="1" border="0">
        <tbody>
            <tr>
                <th class="style_th">設定可能なペット</th>
                <td class="style_td" colspan="3"><?php echo e($data['MobTypes'][0]); ?></td>
            </tr>
            <tr>
                <th class="style_th">要求レベル</th>
                <td class="style_td" colspan="3"><?php echo e($data['RequiredLevel']); ?></td>
            </tr>
            <tr>
                <th class="style_th">最高レベル</th>
                <td class="style_td" colspan="3"><?php echo e($data['MaxLevel']); ?></td>
            </tr>
            <tr>
                <th class="style_th">飛行</th>
                <td class="style_td" colspan="3">@TODO</td>
            </tr>
            <tr>
                <th class="style_th">バックパック</th>
                <td class="style_td" colspan="3">@TODO  あり（Lv50で18マス）</td>
            </tr>
            <tr>
                <th class="style_th" rowspan="12">ビーコン</th>
                <td class="style_td" colspan="3">あり（選択可能数：Lv50で3個、Lv80で4個、Lv90で5個）</td>
            </tr>
            <tr>
                <th class="style_th">効果</th>
                <th class="style_th">効果レベル</th>
                <th class="style_th">要求レベル</th>
            </tr>
            <tr>
                <td class="style_td" rowspan="3"><img src="./?plugin=ref&amp;page=MyPet&amp;src=icon03.png"
                        alt="icon03.png" title="icon03.png" width="18" height="18"> 攻撃力上昇</td>
                <td class="style_td">1<span style="color:gray"><span
                            style="font-size:10px;display:inline-block;line-height:130%;text-indent:0">※</span></span>
                </td>
                <td class="style_td">50</td>
            </tr>
            <tr>
                <td class="style_td">2</td>
                <td class="style_td">80</td>
            </tr>
            <tr>
                <td class="style_td">3</td>
                <td class="style_td">90</td>
            </tr>
            <tr>
                <td class="style_td" rowspan="3"><img src="./?plugin=ref&amp;page=MyPet&amp;src=icon04.png"
                        alt="icon04.png" title="icon04.png" width="18" height="18"> 再生能力</td>
                <td class="style_td">1<span style="color:gray"><span
                            style="font-size:10px;display:inline-block;line-height:130%;text-indent:0">※</span></span>
                </td>
                <td class="style_td">50</td>
            </tr>
            <tr>
                <td class="style_td">2</td>
                <td class="style_td">80</td>
            </tr>
            <tr>
                <td class="style_td">3</td>
                <td class="style_td">90</td>
            </tr>
            <tr>
                <td class="style_td"><img src="./?plugin=ref&amp;page=MyPet&amp;src=icon07.png" alt="icon07.png"
                        title="icon07.png" width="18" height="18"> 暗視</td>
                <td class="style_td">-</td>
                <td class="style_td">50</td>
            </tr>
            <tr>
                <td class="style_td" rowspan="2"><img src="./?plugin=ref&amp;page=MyPet&amp;src=icon08.png"
                        alt="icon08.png" title="icon08.png" width="18" height="18"> 耐性</td>
                <td class="style_td">1<span style="color:gray"><span
                            style="font-size:10px;display:inline-block;line-height:130%;text-indent:0">※</span></span>
                </td>
                <td class="style_td">50</td>
            </tr>
            <tr>
                <td class="style_td">2</td>
                <td class="style_td">80</td>
            </tr>
            <tr>
                <td class="style_td"><img src="./?plugin=ref&amp;page=MyPet&amp;src=icon09.png" alt="icon09.png"
                        title="icon09.png" width="18" height="18"> 火炎耐性</td>
                <td class="style_td">-</td>
                <td class="style_td">50</td>
            </tr>
        </tbody>
    </table>

    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</body>

</html><?php /**PATH /var/www/html/src/templates/petinfo_view.blade.php ENDPATH**/ ?>
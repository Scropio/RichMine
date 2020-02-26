<?php if (!defined('THINK_PATH')) exit(); if(is_array($data['data']['data'])): foreach($data['data']['data'] as $key=>$item): ?><div class="aui-row order-list">
        <div class="aui-col-xs-5">
            <div class="aui-row order-main1">
                <p>
                    <?php if($item["out_userid"] == $userInfo['data']['data']['id']): ?>转账记录
                        <?php else: ?>
                        收款记录<?php endif; ?>
                </p>
                <p>
                    <?php if($item["out_userid"] == $userInfo['data']['data']['id']): ?>收款方：<?php echo ($item["in_username"]); ?>
                        <?php else: ?>
                        转账方：<?php echo ($item["out_username"]); endif; ?>
                </p>
                <p>
                    数量：<?php echo ($item["nums"]); ?>
                </p>
            </div>
        </div>
        <div class="aui-col-xs-7">
            <div class="aui-row order-main2" style="text-align: right">
                <p><?php echo ($item["createtime"]); ?></p>
            </div>
        </div>
    </div><?php endforeach; endif; ?>
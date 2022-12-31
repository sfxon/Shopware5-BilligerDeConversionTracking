{extends file="parent:frontend/checkout/finish.tpl"}

{block name="frontend_index_content"}
    {$smarty.block.parent}
    <img src="https://billiger.de/sale?shop_id={$mv_billiger_tracking_settings.billigerShopId}&oid={$sOrderNumber}&val={if $sAmountWithTax && $sUserData.additional.charge_vat}{$sAmountWithTax}{else}{$sAmount}{/if}" width="1" height="1" border="0" alt="" />
{/block}
[{include file="headitem.tpl" title="GENERAL_ADMIN_TITLE"|oxmultilangassign}]

[{if $readonly}]
    [{assign var="readonly" value="readonly disabled"}]
[{else}]
    [{assign var="readonly" value=""}]
[{/if}]

<form name="transfer" id="transfer" action="[{$oViewConf->getSelfLink()}]" method="post">
    [{$oViewConf->getHiddenSid()}]
    <input type="hidden" name="oxid" value="[{$oxid}]">
    <input type="hidden" name="cl" value="newsletter_main">
    <input type="hidden" name="editlanguage" value="[{$editlanguage}]">
</form>


<form name="myedit" id="myedit" action="[{$oViewConf->getSelfLink()}]" method="post"
      onSubmit="copyLongDesc( 'oxnewsletter__oxtemplate' );">
    [{$oViewConf->getHiddenSid()}]
    <input type="hidden" name="cl" value="newsletter_main">
    <input type="hidden" name="fnc" value="">
    <input type="hidden" name="editval[oxnewsletter__oxtemplate]" value="">

    <table cellspacing="0" cellpadding="0" border="0" width="98%;">
        <tr>
            <td class="edittext">
            </td>
            <td class="edittext"><br>
                <input type="submit" class="edittext" name="save"
                       value="[{oxmultilang ident="tbclnewsletter_recipients"}]"
                       onClick="Javascript:document.myedit.fnc.value='save'"" [{$readonly}]>
            </td>
        </tr>
    </table>

</form>
[{include file="bottomnaviitem.tpl"}]

[{include file="bottomitem.tpl"}]

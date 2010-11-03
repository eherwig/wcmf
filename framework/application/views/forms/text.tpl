{assign var="attributes" value=$attributes|default:'class="default"'}
{if $enabled}
<input type="text" name="{$name}" value="{$value}" {$attributes} {if $error != ''}style="border:1px dotted #EC0000"{/if} onchange="setDirty(this.name);" />
{else}
<span class="disabled" {$attributes}>{$value}</span>
{/if}
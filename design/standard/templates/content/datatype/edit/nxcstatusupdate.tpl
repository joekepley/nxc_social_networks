<div class="block">
    <div class="block social-accounts">
        <div class="element">
            <label><input type="checkbox"><img src={'twitter/connect.png'|ezimage} width="16" /> @joekepley</label>
        </div>
        <div class="element">
            <label><input type="checkbox"><img src={'twitter/connect.png'|ezimage} width="16" /> @blendtweets</label>
        </div>
        <div class="element">
            <label><input type="checkbox"><img src={'facebook/connect.png'|ezimage} width="16" /> Partial Content</label>
        </div>
    </div>
    <div class="block">
        <div class="element">
            <label>Short Update (<span class="short-update-count">0</span>/140 characters)<br />
                <textarea
                        name="{$attribute_base}_data_short_update_{$attribute.id}"
                        class="short-update"
                        rows="2"
                        cols="80"></textarea>
            </label>
        </div>
        <div class="element">
            <label>Long Update<br />
                <textarea
                        name="{$attribute_base}_data_short_update_{$attribute.id}"
                        class="long-update"
                        rows="6"
                        cols="80"></textarea>
            </label>
        </div>
    </div>
</div>
{run-once}
{literal}
<script type="text/javascript">
    $(function () {
        $('.short-update').keyup(function () {
            var shortCount = $('.short-update-count', $(this).closest('div')),
                longUpdate = $('.long-update', $(this).closest('.block')),
                longUpdateVal = longUpdate.val().substring(0,longUpdate.val().length - 1);
            shortCount.text($(this).val().length);

            if (!longUpdate.val() || $(this).val().indexOf(longUpdateVal) === 0) {
                longUpdate.val($(this).val());
            }
        });
    });
</script>
{/literal}
{/run-once}
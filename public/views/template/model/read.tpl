<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-primary">
                <h3 class="card-title text-capitalize">{$info.title}</h3>
                <h5 class="card-category">{$info.description}</h5>
            </div>
            <div class="card-body">
                <table class="table responsive nowrap" width="100%">
                    <thead class="text-primary">
                        <tr>
                        {foreach $column as $cell}
                            <th class="{if $cell eq "id"}text-uppercase{else}text-capitalize{/if}">{$cell}</th>
                        {/foreach}
                        </tr>
                    </thead>
                    <tbody>
                    {foreach $data as $row}
                        <tr>
                        {foreach $row as $cell}
                            {if $cell@key eq 'button'}
                            <td class="td-actions text-right">
                                <div class="btn-group">
                                    <button type="button" class="{$cell.button} btn-round nav-link" data-module="{$cell.module}" data-method="{$cell.method}">
                                        <i class="fa {$cell.icon}"></i>
                                    </button>
                                </div>
                            </td>
                            {else}
                            <td class="{if $cell@key eq 'name'}text-capitalize{/if}">
                                {$cell}
                            </td>
                            {/if}
                            </td>
                        {/foreach}
                        </tr>
                    {/foreach}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-primary">
                <h4 class="card-title text-capitalize">{$title}</h4>
                <p class="card-category">{$description}</p>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead class="text-primary">
                        <tr>
                        {foreach $thead as $column}
                            <th class="text-capitalize">{$column}</th>
                        {/foreach}
                        </tr>
                    </thead>
                    <tbody>
                    {foreach $data as $row}
                        <tr>
                        {foreach $row as $cell}
                        {if $cell@iteration eq 3}
                            <td class="td-actions text-right">
                                <div class="btn-group">
                                    <button type="button" class="{$cell.button} btn-round nav-link" data-module="{$cell.module}" data-method="{$cell.method}">
                                        <i class="fa {$cell.icon}"></i>
                                    </button>
                                </div>
                            </td>
                        {else}
                            <td class="text-capitalize text-left">{$cell}</td>
                        {/if}
                        {/foreach}
                        </tr>
                    {/foreach}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
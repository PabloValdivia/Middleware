<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-primary">
                <h4 class="card-title text-capitalize">{$title}</h4>
                <p class="card-category">{$description}</p>
            </div>
            <div class="card-body">
                <table class="table table-hover table-responsive">
                    <thead class="text-primary">
                        <tr>
                        {foreach $thead as $column}
                            <th>{$column}</th>
                        {/foreach}
                            
                        </tr>
                    </thead>
                    <tbody>
                    {foreach $data as $row}
                        <tr>
                        {foreach $row as $cell}
                           <td>{$cell}</td>
                        {/foreach}
                        </tr>
                    {/foreach}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
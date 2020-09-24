<div class="row" id="info">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header card-header-primary">
                <h4 class="card-title text-capitalize">{$title}</h4>
                <p class="card-category">Crontab info about {$title} sync</p>
            </div>
            <div class="card-body">
                <form>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="bmd-label-floating">Module</label>
                                <input type="text" class="form-control text-capitalize" value="{$title}" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="bmd-label-floating">Last synchronized</label>
                                <input type="text" class="form-control" value="{$synchronized}" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="bmd-label-floating">Frequency to sync</label>
                                <div class="row form-group">
                                    <div class="col-sm-2">
                                        <label class="bmd-label-floating">Minute</label>
                                        <select class="selectpicker form-control" data-style="btn btn-link" id="minute" name="minute">
                                            {section name="minute" loop=61 step=15}
                                                <option value="$smarty.section.minute.index">
                                                    {if $smarty.section.minute.index eq 0}
                                                    *
                                                    {else}
                                                        {$smarty.section.minute.index}
                                                    {/if}
                                                </option>
                                            {/section}
                                        </select>
                                    </div>
                                    <div class="col-sm-2">
                                        <label class="bmd-label-floating">Hour</label>
                                        <select class="selectpicker form-control" data-style="btn btn-link" id="hour" name="hour">
                                            {section name="hour" loop=25}
                                                <option value="$smarty.section.hour.index">
                                                    {if $smarty.section.hour.index eq 0}
                                                    *
                                                    {else}
                                                        {$smarty.section.hour.index}
                                                    {/if}
                                                </option>
                                            {/section}
                                        </select>
                                    </div>
                                    <div class="col-sm-2">
                                        <label class="bmd-label-floating">Weekday</label>
                                        <select class="selectpicker form-control" data-style="btn btn-link" id="week_day" name="week_day">
                                            {section name="weekday" loop=8}
                                                <option value="$smarty.section.weekday.index">
                                                    {if $smarty.section.weekday.index eq 0}
                                                    *
                                                    {else}
                                                        {$smarty.section.weekday.index}
                                                    {/if}
                                                </option>
                                            {/section}
                                        </select>
                                    </div>
                                    <div class="col-sm-2">
                                        <label class="bmd-label-floating">Month</label>
                                        <select class="selectpicker form-control" data-style="btn btn-link" id="month" name="month">
                                            {section name="month" loop=13}
                                                <option value="$smarty.section.month.index">
                                                    {if $smarty.section.month.index eq 0}
                                                    *
                                                    {else}
                                                        {$smarty.section.month.index}
                                                    {/if}
                                                </option>
                                            {/section}
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="bmd-label-floating">Day of the Month</label>
                                        <select class="selectpicker form-control" data-style="btn btn-link" id="month_day" name="month_day">
                                            {section name="day" loop=32}
                                                <option value="$smarty.section.day.index">
                                                    {if $smarty.section.day.index eq 0}
                                                    *
                                                    {else}
                                                        {$smarty.section.day.index}
                                                    {/if}
                                                </option>
                                            {/section}
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                        <div class="form-group">
                            <label>Description</label>
                            <div class="form-group">
                                <textarea class="form-control" rows="3" disabled>{$description}</textarea>
                            </div>
                        </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary pull-right">Update</button>
                    <div class="clearfix"></div>
                </form>
            </div>
            <div class="card-footer text-muted">
            {if $modified->h ge 1 && $modified->days le 1}
                Modified {$modified->h} hour(s) ago 
            {elseif $modified->days ge 1 && $modified->days le 30}
                Modified {$modified->days} day(s) ago
            {elseif $modified->days ge 29 && $modified->days le 366}
                Modified {$modified->m} month ago
            {elseif $modified->days ge 365}
                Modified {$modified->y} year(s) ago
            {else}
                Modified few minutes ago
            {/if}
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-profile">
            <div class="card-avatar card-header-primary img-round">
                <i class="fa {$data.icon}"></i>
            </div>
            <div class="card-body">
                <h6 class="card-category text-capitalize">modulo</h6>
                <h4 class="card-title text-capitalize">{$title}</h4>
                <div class="row">
                    <div class="col-sm-6">
                        <p class="card-category text-capitalize">status: <span class="badge badge-primary">active</span></p>
                    </div>
                    <div class="col-sm-6">
                        <p class="card-category text-capitalize">version: <span class="badge badge-primary">{$data.version}</span></p>
                    </div>
                    <div class="col-sm-12">
                        <p class="card-category text-capitalize text-left">author: {$data.author}</p>
                    </div>
                    <div class="col-sm-12">
                        <p class="card-category text-capitalize text-left">email: <a href="mailto:{$data.email}" class="text-primary text-lowercase">{$data.email}</a></p>
                    </div>
                    <div class="col-sm-12">
                        <a class="btn btn-primary btn-round text-capitalize nav-link" data-module="{$title}" data-method="read">view</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
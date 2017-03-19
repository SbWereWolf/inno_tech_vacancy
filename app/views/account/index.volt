{{ content() }}

{% for account in page.items %}
    {% if loop.first %}
        <table class="table table-bordered table-striped" align="center">
        <thead>
        <tr>
            <th>Account name</th>
            <th>Person name</th>
            <th>E-mail</th>
            <th>Date created</th>
        </tr>
        </thead>
    {% endif %}
    <tbody>
    <tr>
        <td>{{ account['username'] }}</td>
        <td>{{ account['name'] }}</td>
        <td>{{ account['email'] }}</td>
        <td>{{ account['created_at'] }}</td>
    </tr>
    </tbody>
    {% if loop.last %}
        <tbody>
        <tr>
            <td colspan="7" align="right">
                <div class="btn-group">
                    {{ link_to("account/index", '<i class="icon-fast-backward"></i> First', "class": "btn btn-default") }}
                    {{ link_to("account/index?page=" ~ page.before, '<i class="icon-step-backward"></i> Previous', "class": "btn btn-default") }}
                    {{ link_to("account/index?page=" ~ page.next, '<i class="icon-step-forward"></i> Next', "class": "btn btn-default") }}
                    {{ link_to("account/index?page=" ~ page.last, '<i class="icon-fast-forward"></i> Last', "class": "btn btn-default") }}
                    <span class="help-inline">{{ page.current }}/{{ page.total_pages }}</span>
                </div>
            </td>
        </tr>
        <tbody>
        </table>
    {% endif %}
{% else %}
    No accounts are recorded
{% endfor %}

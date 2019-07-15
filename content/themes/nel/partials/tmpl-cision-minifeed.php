<script type="text/html" id="<?php echo $feed['tmpl']; ?>">
    <div class="cision-minifeed">
        <%
        var releases = Releases.Release;
        for (var i=0; i
        <releases.length
                ; i++) {
                var release=releases[i];
                %>
            <div class="feed-item">
                <a class="detail-link" href="<%=release['@attributes'].DetailUrl%>" data-filter="cleantitle"><%=release.Title['cdata-section']%></a><br>
                <p><span data-filter="parseutc"><%=release['@attributes'].PublishDateUtc%></span></p>
            </div>
            <%
            }
            %>
    </div>
</script>
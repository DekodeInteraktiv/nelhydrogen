<?php
// Broker statistics
?>
<script type="text/html" id="<?php echo $feed['tmpl']; ?>">

    <div class="broker-statistics">

        <h3 class="medium-text-center"><?php _e( 'Broker statistics', 'nel' ); ?></h3>

        <div class="row">

            <%
            var brokerStats = manamind[1].brokerStats;
            var buyers = brokerStats.buyers.buyer;
            var sellers = brokerStats.sellers.seller;
            %>

            <% if (buyers.length > 0) { %>
            <div class="columns medium-6">
                <h4 class="medium-text-center"><?php _e( 'Buyers', 'nel' ); ?></h4>
                <table>
                    <thead>
                    <tr>
                        <th><?php _e( 'Broker ID', 'nel' ); ?></th>
                        <th><?php _e( 'Buy vol.', 'nel' ); ?></th>
                        <th><?php _e( 'Avg. buy price', 'nel' ); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <% for ( var i = 0; i < buyers.length; i++ ) { %>
                    <% var buyer = buyers[i]; %>
                    <tr class="">
                        <td><%=buyer.brokerId.text%></td>
                        <td data-filter="round,separator"><%=buyer.volumeBuys.text%></td>
                        <td data-filter="round"><%=buyer.averageBuyPrice.text%></td>
                    </tr>
                    <% } %>
                    </tbody>
                </table>
            </div>
            <% } %>

            <% if (sellers.length > 0) { %>
            <div class="columns medium-6">
                <h4 class="medium-text-center"><?php _e( 'Sellers', 'nel' ); ?></h4>
                <table>
                    <thead>
                    <tr>
                        <th><?php _e( 'Broker ID', 'nel' ); ?></th>
                        <th><?php _e( 'Sell vol.', 'nel' ); ?></th>
                        <th><?php _e( 'Avg. sell price', 'nel' ); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <% for ( var i = 0; i < sellers.length; i++ ) { %>
                    <% var seller = sellers[i]; %>
                    <tr class="">
                        <td><%=seller.brokerId.text%></td>
                        <td data-filter="round,separator"><%=seller.volumeSells.text%></td>
                        <td data-filter="round"><%=seller.averageSellPrice.text%></td>
                    </tr>
                    <% } %>
                    </tbody>
                </table>
            </div>
            <% } %>

        </div>

    </div>

</script>
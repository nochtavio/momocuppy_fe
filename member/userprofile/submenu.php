<div class="submenuorder">
  <ul class="order_menu">
    <li><a <?php echo is_selected($halmember,"history","class=\"selected\"","")?> href="/member/userprofile/order_history/#maincontent"><span>order history</span></a></li>
    <li><a <?php echo is_selected($halmember,"profile","class=\"selected\"","")?> href="/member/userprofile/#maincontent"><span>profile</span></a></li>
    <li><a <?php echo is_selected($halmember,"wishlist","class=\"selected\"","")?> href="/member/userprofile/wishlist/#maincontent"><span>my wishlist</span></a></li>                    
    <li><a <?php echo is_selected($halmember,"address","class=\"selected\"","")?>  href="/member/userprofile/address/#maincontent"><span>address book</span></a></li>                    
    <li><a <?php echo is_selected($halmember,"logout","class=\"selected\"","")?> href="/mmcp/api/member_logout/"><span>log out</span></a></li>                                        
  </ul>
</div>
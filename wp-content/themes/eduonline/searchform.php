<form method="get" id="searchform" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <div>
        <input type="text" value="<?php echo get_search_query(); ?>" name="s" id="s" placeholder="Search here.." />
        <input type="submit" id="searchsubmit" class="fa" value="" />
        <!-- <button id="searchsubmit" type="submit"><i class="fa fa-search"></i></button> -->
    </div>
</form>
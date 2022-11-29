        <section class="area" id="props">
            <div class="box fadeUpTrigger content">
                <div class="search-keyword">
                    <div id="search-wrap-in-page">
                        <form action="index.php" method="get" role="search" id="searchform">
                            <?php if (isset($search['keyword'])) { ?>
                                <?php foreach ($search as $key => $value) { ?>
                                    <input type="text" name="search[keyword]" value="<?php print h($value); ?>" id="search-text-in-page" placeholder="search">
                                <?php } ?>
                            <?php } else { ?>
                                <input type="text" name="search[keyword]" value="" id="search-text-in-page" placeholder="search">
                            <?php } ?>
                            <input type="submit" id="searchsubmit" value="">
                            <input type="hidden" name="module" value="events">
                            <input type="hidden" name="action" value="search">
                            <input type="hidden" name="event_id" value="<?php print h($records['event'] -> event_id); ?>">
                        </form>
                    </div>
                </div><!-- / .search-keyword -->
                <div class="search-select">
                    <div class="select-list-filter">
                        <form action="index.php" method="get">
                            <table>
                                <tr>
                                    <th class="select-title">
                                        <label for="filter">カテゴリ</label>
                                    </th>
                                    <td class="select-name">
                                        <div class="select-wrap">
                                            <select id="filter" name="search[filter]" ONCHANGE="submit(this.form)">
                                                <option value="">選択してください</option>
                                                <?php foreach($records['categorys'] as $record) { ?>
                                                    <option value="<?php print h($record->category_id); ?>"><?php print h($record->category_name); ?></option>
                                                <?php } ?>
                                        </select>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            <input type="hidden" name="module" value="events">
                            <input type="hidden" name="action" value="search">
                            <input type="hidden" name="event_id" value="<?php print h($records['event'] -> event_id); ?>">
                        </form>
                    </div>
                    <div class="select-list-sorting">
                        <form action="index.php" method="get">
                            <table>
                                <tr>
                                    <th class="select-title">
                                        <label for="sorting">並べ替え</label>
                                    </th>
                                    <td class="select-name">
                                        <div class="select-wrap">
                                        <select id="sorting" name="sorting" ONCHANGE="submit(this.form)">
                                            <option value="">選択してください</option>
                                            <option value="0">新着順</option>
                                            <option value="1">価格の安い順</option>
                                            <option value="2">価格の高い順</option>
                                        </select>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            <input type="hidden" name="module" value="events">
                            <input type="hidden" name="action" value="sorting">
                            <input type="hidden" name="event_id" value="<?php print h($records['event'] -> event_id); ?>">
                        </form>
                    </div>
                </div><!-- / .search-select -->
                <div class="pagelink-list">
                    <ul id="in-page-link">
                        <li>
                            <a class="arrow" href="#items">ITEMS</a>
                        </li>
                        <li>
                            <a class="arrow" href="#brands">BRANDS</a>
                        </li>
                        <li>
                            <a class="arrow" href="#originals">ORIGINALS</a>
                        </li>
                    </ul>
                </div><!-- / .pagelink-list -->
            </div><!-- .box .fadeupTrigger #props-->
        </section>
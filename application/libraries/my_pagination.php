<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Pagination extends CI_Pagination {

    var $CI;
    var $_pagination;
    var $_per_page; // 10 item on 1 page
    var $_off = 0;
    var $_num_link;

    function __construct() {
        parent::__construct();        
        $CI = & get_instance();
        
        $CI->config->set_item('enable_query_strings', TRUE);
        
        $this->_per_page = config_item("per_page");
        $this->_num_link = config_item("num_link");
        
        if(isset($_REQUEST['per_page']) && $_REQUEST['per_page']!=""){
            $this->_off = $_REQUEST['per_page'];
        }
    }

    /**
     * Set up config
     * @param type $params
     */
    function initialize(&$params = array()) {
        $this->configPaging($params);
        parent::initialize($params);
    }

    
    /**
     * Defaut config
     * @param type $config
     */
    private function configPaging(&$config = array()) {
        $config['per_page']        = $this->_per_page;
        $config['num_link']        = $this->_num_link;
        $config['full_tag_open']   = '<ul>';
        $config['full_tag_close']  = '</ul>';
        $config['cur_tag_open']    = '<li class="active"><a href="">';
        $config['cur_tag_close']   = '</a></li>';
        $config['next_tag_open']   = '<li>';
        $config['next_tag_close']  = '</li>';
        $config['prev_tag_open']   = '<li>';
        $config['prev_tag_close']  = '</li>';
        $config['last_link']       = 'Last';
        $config['last_tag_open']   = '<li>';
        $config['last_tag_close']  = '</li>';
        $config['first_link']      = 'First';
        $config['first_tag_open']  = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['num_tag_open']    = "<li>";
        $config['num_tag_close']   = "</li>";
    }
    
    function createLinks() {
        return parent::create_links();
    }
    
    /**
     * 
     * @param type $v_label
     * @param type $v_columnid
     * @param type $v_orderby
     * @param type $v_order
     * @param type $v_querystring_page
     * @return type
     */
    function orderLink($v_label, $v_columnid, $v_orderby, $v_order, $v_querystring_page) {
        $v_order = $v_columnid == $v_orderby ? $v_order : '';
        $v_arrow = ($v_order == 'desc' ? '▼' : ($v_order == 'asc' ? '▲' : ''));
        $v_order = $v_order == 'asc' ? 'desc' : 'asc';
        return '<a href="?' . $v_querystring_page . '&amp;orderby=' . $v_columnid . '&amp;order=' . $v_order . '">' . $v_label . ' ' . $v_arrow . '</a>';
    }

    /**
     * 
     * @param type $v_pagination
     * @param type $v_script_name
     * @param type $v_querystring
     * @param int $f_page
     * @param type $v_pagesize
     * @param type $v_pagestart
     * @param type $d_total
     * @param type $v_pagelink
     * @param type $a_navigations
     */
    function makeLinks(&$v_pagination, &$v_script_name, &$v_querystring, &$f_page, &$v_pagesize, &$v_pagestart, &$d_total = 1, &$v_pagelink = 3, &$a_navigations = array(10, 50, 100)) {

        if ($d_total > $v_pagesize) {
            $v_pagination = '';
            $v_href       = '<a href="' . $v_script_name . '&amp;' . $v_querystring . '&amp;page=%d" title="%s %d to %d of %d">%s</a>';
            $v_totalpage  = ceil($d_total / $v_pagesize);

            if ($f_page > 1) {
                $v_prevpage   = $f_page - 1;
                fetch_start_end_total($v_first, $v_last, $v_prevpage, $v_pagesize, $d_total);
                $v_pagination = $v_pagination . '<span>' . sprintf($v_href, $v_prevpage, 'Prev page - Result', $v_first, $v_last, $d_total, '&laquo;') . '</span>';
            }
            else {
                $f_page = 1;
            }

            $i = 0;

            while ($i++ < $v_totalpage) {
                $v_abs = abs($i - $f_page);
                if ($v_abs >= $v_pagelink && $v_pagelink != 0) {
                    if ($i == 1) {
                        fetch_start_end_total($v_first, $v_last, $i, $v_pagesize, $d_total);
                        $v_pagination = $v_pagination . '<span>' . sprintf($v_href, $i, 'First page - Result', $v_first, $v_last, $d_total, $i) . '</span>';
                    }
                    if ($v_abs == $v_pagelink && $i != 1 && $i != $v_totalpage) {
                        $v_pagination = $v_pagination . '<span>...</span>';
                    }
                    if ($i == $v_totalpage) {
                        fetch_start_end_total($v_first, $v_last, $v_totalpage, $v_pagesize, $d_total);
                        $v_pagination = $v_pagination . '<span>' . sprintf($v_href, $v_totalpage, 'Last page - Result', $v_first, $v_last, $d_total, $v_totalpage) . '</span>';
                    }
                    if (in_array($v_abs, $a_navigations) && $i != 1 && $i != $v_totalpage) {
                        fetch_start_end_total($v_first, $v_last, $i, $v_pagesize, $d_total);
                        $v_pagination = $v_pagination . '<span>' . sprintf($v_href, $i, 'Show results', $v_first, $v_last, $d_total, $i) . '</span>';
                    }
                }
                else {
                    if ($i == $f_page) {
                        fetch_start_end_total($v_first, $v_last, $i, $v_pagesize, $d_total);
                        $v_pagination = $v_pagination . '<span class="current" title="Show results ' . $v_first . ' to ' . $v_last . ' of ' . $d_total . '">' . $i . '</span>';
                    }
                    else {
                        fetch_start_end_total($v_first, $v_last, $i, $v_pagesize, $d_total);
                        $v_pagination = $v_pagination . '<span>' . sprintf($v_href, $i, 'Show results', $v_first, $v_last, $d_total, $i) . '</span>';
                    }
                }
            }

            if ($f_page < $v_totalpage) {
                $v_nextpage   = $f_page + 1;
                fetch_start_end_total($v_first, $v_last, $v_nextpage, $v_pagesize, $d_total);
                $v_pagination = $v_pagination . '<span>' . sprintf($v_href, $v_nextpage, 'Next page - Result', $v_first, $v_last, $d_total, '&raquo;') . '</span>';
            }

            $v_pagestart = ($f_page - 1) * $v_pagesize;

            if ($v_pagestart > $d_total) {
                $v_pagestart = $d_total - $v_pagesize - 1;
            }

            if ($v_pagestart < 0) {
                $v_pagestart  = 0;
            }
            $v_pagination = '<div class="pagination"><div><span class="total">Total: ' . $d_total . ' | Page ' . $f_page . ' of ' . $v_totalpage . '</span>' . $v_pagination . '</div></div>';
        }
        else {
            $v_pagination = '<div class="pagination"><div><span class="total">Total: ' . $d_total . '</span></div></div>';
        }
    }
    
    /**
     * 
     * @param string $v_order
     * @param string $f_order
     * @param type $f_orderby
     * @param type $a_tablecolumns
     */

    function makeOrder(&$v_order, &$f_order, &$f_orderby, &$a_tablecolumns) {
        if ($f_order != 'desc') {
            $f_order = 'asc';
        }

        if (!in_array($f_orderby, $a_tablecolumns['columns'])) {
            $f_orderby = $a_tablecolumns['columns'][0];
        }
        $v_order   = " order by $f_orderby " . strtolower($f_order);
    }

}


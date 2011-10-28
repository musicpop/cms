<?php  if(!defined('DEDEINC')) exit('dedecms');
/**
 * �ַ���С����
 *
 * @version        $Id: string.helper.php 5 14:24 2010��7��5��Z tianya $
 * @package        DedeCMS.Helpers
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
//ƴ���Ļ�������
$pinyins = Array();

/**
 *  ���Ľ�ȡ2�����ֽڽ�ȡģʽ
 *  �����request�����ݣ�����ʹ���������
 *
 * @access    public
 * @param     string  $str  ��Ҫ��ȡ���ַ���
 * @param     int  $slen  ��ȡ�ĳ���
 * @param     int  $startdd  ��ʼ��Ǵ�
 * @return    string
 */
if ( ! function_exists('cn_substrR'))
{
    function cn_substrR($str, $slen, $startdd=0)
    {
        $str = cn_substr(stripslashes($str), $slen, $startdd);
        return addslashes($str);
    }
}

/**
 *  ���Ľ�ȡ2�����ֽڽ�ȡģʽ
 *
 * @access    public
 * @param     string  $str  ��Ҫ��ȡ���ַ���
 * @param     int  $slen  ��ȡ�ĳ���
 * @param     int  $startdd  ��ʼ��Ǵ�
 * @return    string
 */
if ( ! function_exists('cn_substr'))
{
    function cn_substr($str, $slen, $startdd=0)
    {
        global $cfg_soft_lang;
        if($cfg_soft_lang=='utf-8')
        {
            return cn_substr_utf8($str, $slen, $startdd);
        }
        $restr = '';
        $c = '';
        $str_len = strlen($str);
        if($str_len < $startdd+1)
        {
            return '';
        }
        if($str_len < $startdd + $slen || $slen==0)
        {
            $slen = $str_len - $startdd;
        }
        $enddd = $startdd + $slen - 1;
        for($i=0;$i<$str_len;$i++)
        {
            if($startdd==0)
            {
                $restr .= $c;
            }
            else if($i > $startdd)
            {
                $restr .= $c;
            }

            if(ord($str[$i])>0x80)
            {
                if($str_len>$i+1)
                {
                    $c = $str[$i].$str[$i+1];
                }
                $i++;
            }
            else
            {
                $c = $str[$i];
            }

            if($i >= $enddd)
            {
                if(strlen($restr)+strlen($c)>$slen)
                {
                    break;
                }
                else
                {
                    $restr .= $c;
                    break;
                }
            }
        }
        return $restr;
    }
}

/**
 *  utf-8���Ľ�ȡ�����ֽڽ�ȡģʽ
 *
 * @access    public
 * @param     string  $str  ��Ҫ��ȡ���ַ���
 * @param     int  $slen  ��ȡ�ĳ���
 * @param     int  $startdd  ��ʼ��Ǵ�
 * @return    string
 */
if ( ! function_exists('cn_substr_utf8'))
{
    function cn_substr_utf8($str, $length, $start=0)
    {
        if(strlen($str) < $start+1)
        {
            return '';
        }
        preg_match_all("/./su", $str, $ar);
        $str = '';
        $tstr = '';

        //Ϊ�˼���mysql4.1���°汾,�����ݿ�varcharһ��,����ʹ�ð��ֽڽ�ȡ
        for($i=0; isset($ar[0][$i]); $i++)
        {
            if(strlen($tstr) < $start)
            {
                $tstr .= $ar[0][$i];
            }
            else
            {
                if(strlen($str) < $length + strlen($ar[0][$i]) )
                {
                    $str .= $ar[0][$i];
                }
                else
                {
                    break;
                }
            }
        }
        return $str;
    }
}

/**
 *  HTMLת��Ϊ�ı�
 *
 * @param    string  $str ��Ҫת�����ַ���
 * @param    string  $r   ���$r=0ֱ�ӷ�������,������Ҫʹ�÷�б�������ַ���
 * @return   string
 */
if ( ! function_exists('Html2Text'))
{
    function Html2Text($str,$r=0)
    {
        if(!function_exists('SpHtml2Text'))
        {
            require_once(DEDEINC."/inc/inc_fun_funString.php");
        }
        if($r==0)
        {
            return SpHtml2Text($str);
        }
        else
        {
            $str = SpHtml2Text(stripslashes($str));
            return addslashes($str);
        }
    }
}


/**
 *  �ı�תHTML
 *
 * @param    string  $txt ��Ҫת�����ı�����
 * @return   string
 */
if ( ! function_exists('Text2Html'))
{
    function Text2Html($txt)
    {
        $txt = str_replace("  ", "��", $txt);
        $txt = str_replace("<", "&lt;", $txt);
        $txt = str_replace(">", "&gt;", $txt);
        $txt = preg_replace("/[\r\n]{1,}/isU", "<br/>\r\n", $txt);
        return $txt;
    }
}

/**
 *  ��ȡ����ַ�
 *
 * @param     string  $fnum  �����ַ���
 * @return    string
 */
if ( ! function_exists('GetAlabNum'))
{
    function GetAlabNum($fnum)
    {
        $nums = array("��","��","��","��","��","��","��","��","��","��");
        //$fnums = "0123456789";
        $fnums = array("0","1","2","3","4","5","6","7","8","9");
        $fnum = str_replace($nums, $fnums, $fnum);
        $fnum = preg_replace("/[^0-9\.-]/", '', $fnum);
        if($fnum=='')
        {
            $fnum=0;
        }
        return $fnum;
    }
}

/**
 *  ��ȡƴ����gbk����Ϊ׼
 *
 * @access    public
 * @param     string  $str     �ַ�����Ϣ
 * @param     int     $ishead  �Ƿ�ȡͷ��ĸ
 * @param     int     $isclose �Ƿ�ر��ַ�����Դ
 * @return    string
 */
if ( ! function_exists('GetPinyin'))
{
    function GetPinyin($str, $ishead=0, $isclose=1)
    {
        global $cfg_soft_lang;
        if(!function_exists('SpGetPinyin'))
        {
            //ȫ�ֺ�������inc_fun_funAdmin.php�ļ��к�����һ��ӳ��
            require_once(DEDEINC."/inc/inc_fun_funAdmin.php");
        }
        if($cfg_soft_lang=='utf-8')
        {
            return SpGetPinyin(utf82gb($str), $ishead, $isclose);
        }
        else
        {
            return SpGetPinyin($str, $ishead, $isclose);
        }
    }
}
/**
 *  ��ʵ��html����ת���ɱ�׼html���루����php4��
 *
 * @access    public
 * @param     string  $str     �ַ�����Ϣ
 * @param     long    $options  �滻���ַ���
 * @return    string
 */

if ( ! function_exists('htmlspecialchars_decode'))
{
        function htmlspecialchars_decode($str, $options=ENT_COMPAT) {
                $trans = get_html_translation_table(HTML_SPECIALCHARS, $options);

                $decode = ARRAY();
                foreach ($trans AS $char=>$entity) {
                        $decode[$entity] = $char;
                }

                $str = strtr($str, $decode);

                return $str;
        }
}
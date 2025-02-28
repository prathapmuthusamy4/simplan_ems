SELECT
     *
FROM
     t_btclient tb
WHERE
     tb.f_del_flg = '{$param.where.f_del_flg|addslashes}'

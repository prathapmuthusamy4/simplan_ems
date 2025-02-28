SELECT
     zip.f_address
FROM
    m_zip zip
WHERE
{if isset($param.where.f_zip_cd) && !is_empty($param.where.f_zip_cd)}
    zip.f_zip_cd = {$param.where.f_zip_cd|addslashes}
{/if}
<?php

class Documentos extends Conectar
{
    public function obtenerDocumentos($cedula,$tipoinsc,$formainsc,$tipoprof) {
        $conectar = parent::ConexionSirepro();
        $sql = "SELECT distinct * FROM
(
SELECT *
FROM (
 -- Obtener todas las filas de tabla1
	WITH tabla1 AS (
		SELECT b.tipoprofe, b.tipoinsc, b.formainsc,
			   b.norden, b.codtdoc, a.nomtdoc
		FROM tdocumentos a
		JOIN documlist b ON a.codtdoc = b.codtdoc
		WHERE b.formainsc = :formainsc
		  AND b.tipoinsc = :tipoinsc
		  AND b.tipoprofe = :tipoprof
	),
	-- Obtener todas las filas de tabla4
	tabla4 AS (
		SELECT b.tipoprofe, b.tipoinsc, b.formainsc,
			   b.norden, b.codtdoc, a.nomtdoc
		FROM tdocumentos a
		JOIN documlist b ON a.codtdoc = b.codtdoc
		WHERE b.formainsc = :formainsc
		  AND b.tipoinsc = :tipoinsc
		  AND b.tipoprofe = 4
	)
	-- Seleccionar todas las filas de tabla1
	SELECT * FROM tabla1
	UNION ALL
	-- Seleccionar las filas de tabla4 que no están en tabla1
	SELECT * FROM tabla4
	WHERE codtdoc NOT IN (
		SELECT codtdoc FROM tabla1
	)
	ORDER BY codtdoc

) AS lista
INNER JOIN
(
select cedula, norden norprof,tipoprof,tipoinsc from rprofesional
where cedula  LIKE :cedula
and   tipoinsc = :tipoinsc

) rp
on lista.tipoprofe = rp.tipoprof
and lista.tipoinsc = rp.tipoinsc
order by lista.codtdoc
) dato
left join
(
select cedula,fechasol,norden,codtdoc,norprof from dcomprobantes
where cedula like  :cedula

) dcomp
on dato.cedula = dcomp.cedula
and dato.codtdoc = dcomp.codtdoc
and dato.norden   = dcomp.norden";
       error_log($sql) ;        
        $query = $conectar->prepare($sql);
        $query->bindValue(':cedula', $cedula, PDO::PARAM_STR); 
        $query->bindValue(':tipoinsc', $tipoinsc, PDO::PARAM_INT); 
        $query->bindValue(':formainsc', $formainsc, PDO::PARAM_INT);
        $query->bindValue(':tipoprof', $formainsc, PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>


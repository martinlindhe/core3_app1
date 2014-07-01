<?php
namespace JsMap;

class CoordinateConvertParameters
{
    var $n;
    var $e;
    var $axis;
    var $flattening;
    var $latOfOrigin;
    var $centralMeridian;
    var $scale;
    var $falseNorthing;
    var $falseEasting;
}

class CoordinateConverter
{
    /**
     * Converts "SWEREF 99 TM" coordinates to WGS84
     *
     * @return Coordinate
     */
    public static function SWEREF99TM_to_WGS84($n, $e)
    {
        // FIXME what is the range of this coord system?
        if ($n > 9999999 || $e > 99999999 ||
            $n < 1000 || $e < 1000) {
            throw new \Exception('invalid coords');
        }

        $p = new CoordinateConvertParameters();
        $p->n = $n;
        $p->e = $e;
        $p->axis = 6378137.0; // GRS 80
        $p->flattening = 1.0 / 298.257222101; // GRS 80
        $p->latOfOrigin = 0.0;
        $p->centralMeridian = 15.00;
        $p->scale = 0.9996;
        $p->falseNorthing = 0.0;
        $p->falseEasting = 500000.0;
        return self::gridToGeodetic($p);
    }

    /**
     * Conversion from grid coordinates to geodetic coordinates.
     *
     * based on: http://mellifica.se/geodesi/gausskruger.js
     * "Gauss Conformal Projection (Transverse Mercator), Krügers Formulas"
     *
     * @return Coordinate
     */
    private static function gridToGeodetic(CoordinateConvertParameters $p)
    {
        //Prepare ellipsoid-based stuff
        $e2 = $p->flattening * (2.0 - $p->flattening);
        $n  = $p->flattening / (2.0 - $p->flattening);
        $a_roof = $p->axis / (1.0 + $n) * (1.0 + $n*$n/4.0 + $n*$n*$n*$n/64.0);

        $delta1 =    $n/2.0      - 2.0*$n*$n/3.0        +  37.0*$n*$n*$n/96.0   - $n*$n*$n*$n/360.0;
        $delta2 = $n*$n/48.0     + $n*$n*$n/15.0        - 437.0*$n*$n*$n*$n/1440.0;
        $delta3 = 17.0*$n*$n*$n/480.0 - 37*$n*$n*$n*$n/840.0;
        $delta4 = 4397.0*$n*$n*$n*$n/161280.0;

        $Astar =   $e2 +       $e2*$e2 +        $e2*$e2*$e2 +       $e2*$e2*$e2*$e2;
        $Bstar =         -(7.0*$e2*$e2 +   17.0*$e2*$e2*$e2 +  30.0*$e2*$e2*$e2*$e2) / 6.0;
        $Cstar =                         (224.0*$e2*$e2*$e2 + 889.0*$e2*$e2*$e2*$e2) / 120.0;
        $Dstar =                                           -(4279.0*$e2*$e2*$e2*$e2) / 1260.0;

        //Convert
        $deg_to_rad = M_PI / 180;
        $lambda_zero = $p->centralMeridian * $deg_to_rad;
        $xi  = ($p->n - $p->falseNorthing) / ($p->scale * $a_roof);
        $eta = ($p->e - $p->falseEasting)  / ($p->scale * $a_roof);
        $xi_prim = $xi -
            $delta1 * sin(2.0*$xi) * cosh(2.0*$eta) -
            $delta2 * sin(4.0*$xi) * cosh(4.0*$eta) -
            $delta3 * sin(6.0*$xi) * cosh(6.0*$eta) -
            $delta4 * sin(8.0*$xi) * cosh(8.0*$eta);
        $eta_prim = $eta -
            $delta1 * cos(2.0*$xi) * sinh(2.0*$eta) -
            $delta2 * cos(4.0*$xi) * sinh(4.0*$eta) -
            $delta3 * cos(6.0*$xi) * sinh(6.0*$eta) -
            $delta4 * cos(8.0*$xi) * sinh(8.0*$eta);

        $phi_star     = asin(sin($xi_prim)   / cosh($eta_prim));
        $delta_lambda = atan(sinh($eta_prim) / cos($xi_prim));

        $lon_radian = $lambda_zero + $delta_lambda;
        $lat_radian =
            $phi_star + sin($phi_star) * cos($phi_star) *
            ($Astar +
             $Bstar * pow(sin($phi_star), 2) +
             $Cstar * pow(sin($phi_star), 4) +
             $Dstar * pow(sin($phi_star), 6));

        $coord = new Coordinate();
        $coord->latitude = $lat_radian * 180.0 / M_PI;
        $coord->longitude = $lon_radian * 180.0 / M_PI;
        return $coord;
    }
}

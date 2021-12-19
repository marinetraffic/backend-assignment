<?php
namespace App\Http\Controllers;
use App\Details;
use Log;
use Illuminate\Http\Request;

class VSDetailsController extends Controller
{
  public function showDetails(Request $request){

      /**
      * Filters send from the request side.Assumed that mmsi is comma separated string if multiple mmsi are send,
      * and timestamp has two range.
      **/
      $mmsi = $request->has('mmsi') ? $request->input('mmsi'): '' ;
      $lon = $request->has('lon') ? $request->input('lon'): '' ;
      $lat = $request->has('lat') ? $request->input('lat'): '' ;
      $from_time_intervel = $request->has('from_time') ? $request->input('from_time'): '' ;
      $to_time_intervel = $request->has('to_time') ? $request->input('to_time'): '' ;


      $mmsi_array = explode(',',$mmsi);// make mmsi as array by the comma sepatator

      //instantiate a query and then build up conditions based on request variables
      $details = Details::query();

      if(sizeof($mmsi_array) > 0){
        $details->whereIn('mmsi',$mmsi_array);
      }
      if($lon != ''){
        $details->where('lon','=',$lon);
      }
      if($lat != ''){
        $details->where('lat','=',$lat);
      }
      if($from_time_intervel != ''){
        $details->where('timestamp','>=',$from_time_intervel);
      }
      if($to_time_intervel != ''){
        $details->where('timestamp','<=',$to_time_intervel);
      }
      $details_data = $details->get();
      
      return response()->json($details_data);
 
  }
    /**
     * Create function is used to load the JSON File data to database,
     *Send the json file name as files with json array with specified fields.
     *
     */
    public function create(Request $request)
    {
        $inpusqt = $request->file('files'); //get the file details
        $data = (json_decode(file_get_contents($inpusqt->getRealPath()),true)); //will generate the content of the file as array
        $details = \DB::table('vs_details')->insert($data);//directly insert the array to table vs_details
        return response()->json($details, 201);  // return the response in json format
    }
  
}

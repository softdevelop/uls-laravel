<?php namespace App\Services;

use App\Services\UserService;

class TermService{

	public static function tagHtml($term, $user){

		$userService = new UserService();

        $count = 0;

        $tagHtml = [];

        foreach ($term->fields as $key => &$value) {

            if($value['endField']){

               $postWrappers = $term->fields()->find($value['endField'])->postWrappers()->get()->toArray();
          
                foreach ($postWrappers as $key1 => $value1) {
                   /* var_dump($value['_id']);
                    dd($value1);*/
                    if($value1['startField']==$value['_id']){

                        $value['preWrapperHtml'] = $userService->getInforUser($value['preWrapperHtml'], $user->id);

                        $tagHtml[$count]['html']='<div class="removeWrapperAppent">' . $value['preWrapperHtml'] . $value1['html'] . '</div>';

                        $tagHtml[$count]['keyStar'] = $key;
                       /* dd($tagHtml[$count]);die;*/
                        for($i=$key; $i<count($term->fields); $i++){

                            if($value['endField'] == $term->fields[$i]['_id']){

                                 $tagHtml[$count]['keyEnd'] = $i;

                                 break;
                            }
                        }
                    }
                }
                if(count($tagHtml) == 1){

                    $tagHtml[0]['parent'] = 'parent_0';

                } else{

                        for($i=$count-1; $i>=0; $i--){

                            if($tagHtml[$count]['keyStar'] < $tagHtml[$i]['keyEnd'] && $tagHtml[$count]['keyEnd'] <= $tagHtml[$i]['keyEnd']){

                                $tagHtml[$count]['parent'] = $i;

                                break;
                            }
                            if($i == 0){

                                $tagHtml[$count]['parent'] = 'parent'.'_'.$count;
                            }
                           
                        }
                }

                $count++;
            }
        }

		return $tagHtml;
	}

}
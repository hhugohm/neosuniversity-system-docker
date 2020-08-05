<?php

use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\RequestContext;

/**
 * This class has been auto-generated
 * by the Symfony Routing Component.
 */
class appProdProjectContainerUrlMatcher extends Symfony\Bundle\FrameworkBundle\Routing\RedirectableUrlMatcher
{
    public function __construct(RequestContext $context)
    {
        $this->context = $context;
    }

    public function match($rawPathinfo)
    {
        $allow = array();
        $pathinfo = rawurldecode($rawPathinfo);
        $trimmedPathinfo = rtrim($pathinfo, '/');
        $context = $this->context;
        $request = $this->request;
        $requestMethod = $canonicalMethod = $context->getMethod();
        $scheme = $context->getScheme();

        if ('HEAD' === $requestMethod) {
            $canonicalMethod = 'GET';
        }


        if (0 === strpos($pathinfo, '/api')) {
            // app_author_getall
            if ('/api/author' === $pathinfo) {
                if ('GET' !== $canonicalMethod) {
                    $allow[] = 'GET';
                    goto not_app_author_getall;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\AuthorController::getAll',  '_route' => 'app_author_getall',);
            }
            not_app_author_getall:

            if (0 === strpos($pathinfo, '/api/c')) {
                // app_category_getall
                if ('/api/category' === $pathinfo) {
                    if ('GET' !== $canonicalMethod) {
                        $allow[] = 'GET';
                        goto not_app_category_getall;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\CategoryController::getAll',  '_route' => 'app_category_getall',);
                }
                not_app_category_getall:

                if (0 === strpos($pathinfo, '/api/course')) {
                    // app_course_validatesubscription
                    if ('/api/course/validateSubscription' === $pathinfo) {
                        if ('POST' !== $canonicalMethod) {
                            $allow[] = 'POST';
                            goto not_app_course_validatesubscription;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\CourseController::validateSubscription',  '_route' => 'app_course_validatesubscription',);
                    }
                    not_app_course_validatesubscription:

                    if (0 === strpos($pathinfo, '/api/course/subscription')) {
                        // app_course_subscription
                        if ('/api/course/subscription' === $pathinfo) {
                            if ('POST' !== $canonicalMethod) {
                                $allow[] = 'POST';
                                goto not_app_course_subscription;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\CourseController::subscription',  '_route' => 'app_course_subscription',);
                        }
                        not_app_course_subscription:

                        // app_course_subscriptionpremier
                        if ('/api/course/subscriptionPremier' === $pathinfo) {
                            if ('POST' !== $canonicalMethod) {
                                $allow[] = 'POST';
                                goto not_app_course_subscriptionpremier;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\CourseController::subscriptionPremier',  '_route' => 'app_course_subscriptionpremier',);
                        }
                        not_app_course_subscriptionpremier:

                    }

                    elseif (0 === strpos($pathinfo, '/api/course/save')) {
                        // app_course_savetwclasscomplete
                        if ('/api/course/saveTwClassComplete' === $pathinfo) {
                            if ('POST' !== $canonicalMethod) {
                                $allow[] = 'POST';
                                goto not_app_course_savetwclasscomplete;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\CourseController::saveTwClassComplete',  '_route' => 'app_course_savetwclasscomplete',);
                        }
                        not_app_course_savetwclasscomplete:

                        // app_course_savenewsection
                        if ('/api/course/saveNewSection' === $pathinfo) {
                            if ('POST' !== $canonicalMethod) {
                                $allow[] = 'POST';
                                goto not_app_course_savenewsection;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\CourseController::saveNewSection',  '_route' => 'app_course_savenewsection',);
                        }
                        not_app_course_savenewsection:

                        // app_course_savenewclass
                        if ('/api/course/saveNewClass' === $pathinfo) {
                            if ('POST' !== $canonicalMethod) {
                                $allow[] = 'POST';
                                goto not_app_course_savenewclass;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\CourseController::saveNewClass',  '_route' => 'app_course_savenewclass',);
                        }
                        not_app_course_savenewclass:

                    }

                    elseif (0 === strpos($pathinfo, '/api/course/a')) {
                        // app_course_allsections
                        if ('/api/course/allsections' === $pathinfo) {
                            if ('POST' !== $canonicalMethod) {
                                $allow[] = 'POST';
                                goto not_app_course_allsections;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\CourseController::allSections',  '_route' => 'app_course_allsections',);
                        }
                        not_app_course_allsections:

                        // app_course_alltwsections
                        if ('/api/course/alltwsections' === $pathinfo) {
                            if ('POST' !== $canonicalMethod) {
                                $allow[] = 'POST';
                                goto not_app_course_alltwsections;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\CourseController::allTwSections',  '_route' => 'app_course_alltwsections',);
                        }
                        not_app_course_alltwsections:

                        // app_course_addnewcourse
                        if ('/api/course/addNewCourse' === $pathinfo) {
                            if ('POST' !== $canonicalMethod) {
                                $allow[] = 'POST';
                                goto not_app_course_addnewcourse;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\CourseController::addNewCourse',  '_route' => 'app_course_addnewcourse',);
                        }
                        not_app_course_addnewcourse:

                        // app_course_addfiletoclass
                        if ('/api/course/addFileToClass' === $pathinfo) {
                            if ('POST' !== $canonicalMethod) {
                                $allow[] = 'POST';
                                goto not_app_course_addfiletoclass;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\CourseController::addFileToClass',  '_route' => 'app_course_addfiletoclass',);
                        }
                        not_app_course_addfiletoclass:

                    }

                    elseif (0 === strpos($pathinfo, '/api/course/get')) {
                        if (0 === strpos($pathinfo, '/api/course/getT')) {
                            // app_course_gettrclass
                            if ('/api/course/getTrClass' === $pathinfo) {
                                if ('POST' !== $canonicalMethod) {
                                    $allow[] = 'POST';
                                    goto not_app_course_gettrclass;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\CourseController::getTrClass',  '_route' => 'app_course_gettrclass',);
                            }
                            not_app_course_gettrclass:

                            if (0 === strpos($pathinfo, '/api/course/getTrCourseSections')) {
                                // app_course_gettrcoursesectionspremier
                                if ('/api/course/getTrCourseSectionsPremier' === $pathinfo) {
                                    if ('POST' !== $canonicalMethod) {
                                        $allow[] = 'POST';
                                        goto not_app_course_gettrcoursesectionspremier;
                                    }

                                    return array (  '_controller' => 'AppBundle\\Controller\\CourseController::getTrCourseSectionsPremier',  '_route' => 'app_course_gettrcoursesectionspremier',);
                                }
                                not_app_course_gettrcoursesectionspremier:

                                // app_course_gettrcoursesections
                                if ('/api/course/getTrCourseSections' === $pathinfo) {
                                    if ('POST' !== $canonicalMethod) {
                                        $allow[] = 'POST';
                                        goto not_app_course_gettrcoursesections;
                                    }

                                    return array (  '_controller' => 'AppBundle\\Controller\\CourseController::getTrCourseSections',  '_route' => 'app_course_gettrcoursesections',);
                                }
                                not_app_course_gettrcoursesections:

                            }

                            // app_course_gettwclass
                            if ('/api/course/getTwClass' === $pathinfo) {
                                if ('POST' !== $canonicalMethod) {
                                    $allow[] = 'POST';
                                    goto not_app_course_gettwclass;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\CourseController::getTwClass',  '_route' => 'app_course_gettwclass',);
                            }
                            not_app_course_gettwclass:

                        }

                        // app_course_getcoursesbyuser
                        if ('/api/course/getCoursesByUser' === $pathinfo) {
                            if ('POST' !== $canonicalMethod) {
                                $allow[] = 'POST';
                                goto not_app_course_getcoursesbyuser;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\CourseController::getCoursesByUser',  '_route' => 'app_course_getcoursesbyuser',);
                        }
                        not_app_course_getcoursesbyuser:

                        // app_course_getusersbycourse
                        if ('/api/course/getUsersByCourse' === $pathinfo) {
                            if ('POST' !== $canonicalMethod) {
                                $allow[] = 'POST';
                                goto not_app_course_getusersbycourse;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\CourseController::getUsersByCourse',  '_route' => 'app_course_getusersbycourse',);
                        }
                        not_app_course_getusersbycourse:

                        // app_course_getuserslikemail
                        if ('/api/course/getUserslikemail' === $pathinfo) {
                            if ('POST' !== $canonicalMethod) {
                                $allow[] = 'POST';
                                goto not_app_course_getuserslikemail;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\CourseController::getUsersLikeMail',  '_route' => 'app_course_getuserslikemail',);
                        }
                        not_app_course_getuserslikemail:

                        // app_course_getfilesbyclass
                        if ('/api/course/getFilesByClass' === $pathinfo) {
                            if ('POST' !== $canonicalMethod) {
                                $allow[] = 'POST';
                                goto not_app_course_getfilesbyclass;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\CourseController::getFilesByClass',  '_route' => 'app_course_getfilesbyclass',);
                        }
                        not_app_course_getfilesbyclass:

                    }

                    elseif (0 === strpos($pathinfo, '/api/course/update')) {
                        // app_course_updatecourse
                        if ('/api/course/updateCourse' === $pathinfo) {
                            if ('POST' !== $canonicalMethod) {
                                $allow[] = 'POST';
                                goto not_app_course_updatecourse;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\CourseController::updateCourse',  '_route' => 'app_course_updatecourse',);
                        }
                        not_app_course_updatecourse:

                        // app_course_updateclase
                        if ('/api/course/updateClase' === $pathinfo) {
                            if ('POST' !== $canonicalMethod) {
                                $allow[] = 'POST';
                                goto not_app_course_updateclase;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\CourseController::updateClase',  '_route' => 'app_course_updateclase',);
                        }
                        not_app_course_updateclase:

                        // app_course_updatesection
                        if ('/api/course/updateSection' === $pathinfo) {
                            if ('POST' !== $canonicalMethod) {
                                $allow[] = 'POST';
                                goto not_app_course_updatesection;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\CourseController::updateSection',  '_route' => 'app_course_updatesection',);
                        }
                        not_app_course_updatesection:

                        // app_course_updatefile
                        if ('/api/course/updateFile' === $pathinfo) {
                            if ('POST' !== $canonicalMethod) {
                                $allow[] = 'POST';
                                goto not_app_course_updatefile;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\CourseController::updateFile',  '_route' => 'app_course_updatefile',);
                        }
                        not_app_course_updatefile:

                    }

                }

                // app_password_changepassword
                if ('/api/changePassword' === $pathinfo) {
                    if ('POST' !== $canonicalMethod) {
                        $allow[] = 'POST';
                        goto not_app_password_changepassword;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\PasswordController::changePassword',  '_route' => 'app_password_changepassword',);
                }
                not_app_password_changepassword:

            }

            elseif (0 === strpos($pathinfo, '/api/getcourse')) {
                // app_course_getall
                if ('/api/getcourse' === $pathinfo) {
                    if ('GET' !== $canonicalMethod) {
                        $allow[] = 'GET';
                        goto not_app_course_getall;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\CourseController::getAll',  '_route' => 'app_course_getall',);
                }
                not_app_course_getall:

                // app_course_getbyid
                if ('/api/getcourse' === $pathinfo) {
                    if ('POST' !== $canonicalMethod) {
                        $allow[] = 'POST';
                        goto not_app_course_getbyid;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\CourseController::getById',  '_route' => 'app_course_getbyid',);
                }
                not_app_course_getbyid:

            }

            // app_course_getpremiercourses
            if ('/api/getPremierCourses' === $pathinfo) {
                if ('POST' !== $canonicalMethod) {
                    $allow[] = 'POST';
                    goto not_app_course_getpremiercourses;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\CourseController::getPremierCourses',  '_route' => 'app_course_getpremiercourses',);
            }
            not_app_course_getpremiercourses:

            // app_login_login
            if ('/api/login' === $pathinfo) {
                if ('POST' !== $canonicalMethod) {
                    $allow[] = 'POST';
                    goto not_app_login_login;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\LoginController::login',  '_route' => 'app_login_login',);
            }
            not_app_login_login:

            // app_password_requestresetpwd
            if ('/api/requestResetPwd' === $pathinfo) {
                if ('POST' !== $canonicalMethod) {
                    $allow[] = 'POST';
                    goto not_app_password_requestresetpwd;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\PasswordController::requestResetPwd',  '_route' => 'app_password_requestresetpwd',);
            }
            not_app_password_requestresetpwd:

            // app_password_validateurl
            if ('/api/validateUrl' === $pathinfo) {
                if ('POST' !== $canonicalMethod) {
                    $allow[] = 'POST';
                    goto not_app_password_validateurl;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\PasswordController::validateUrl',  '_route' => 'app_password_validateurl',);
            }
            not_app_password_validateurl:

            // app_signup_signup
            if ('/api/signup' === $pathinfo) {
                if ('POST' !== $canonicalMethod) {
                    $allow[] = 'POST';
                    goto not_app_signup_signup;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\SignUpController::signUp',  '_route' => 'app_signup_signup',);
            }
            not_app_signup_signup:

        }

        // homepage
        if ('' === $trimmedPathinfo) {
            if (substr($pathinfo, -1) !== '/') {
                return $this->redirect($rawPathinfo.'/', 'homepage');
            }

            return array (  '_controller' => 'AppBundle\\Controller\\DefaultController::indexAction',  '_route' => 'homepage',);
        }

        // app_user_get
        if ('/user' === $pathinfo) {
            if ('GET' !== $canonicalMethod) {
                $allow[] = 'GET';
                goto not_app_user_get;
            }

            return array (  '_controller' => 'AppBundle\\Controller\\UserController::getAction',  '_route' => 'app_user_get',);
        }
        not_app_user_get:

        throw 0 < count($allow) ? new MethodNotAllowedException(array_unique($allow)) : new ResourceNotFoundException();
    }
}

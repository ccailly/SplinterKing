import selenium_drivers as sd

import sys
import time
import json


# Return data like this sample
# {
#   "mail": "WdohIvnUnO7q59c@mailsac.com",
#   "birthdate": "01/01/1970",
#   "hasKids": false,
#   "points": 0,
#   "coupons": [
#     {
#       "id": "BPL9O8CS",
#       "label": "1 Whopper offert pour votre anniversaire ",
#       "description": "Offre valable un mois hors service de livraison. Retrouvez la liste des restaurants participants et les conditions g\u00e9n\u00e9rales d\u2019utilisation du programme de fid\u00e9lit\u00e9 Kingdom sur l'application Burger King France et sur burgerking.fr. Pour connaitre le d\u00e9tail des produits offerts dans le cadre du Programme de fid\u00e9lit\u00e9 Kingdom, consultez les conditions g\u00e9n\u00e9rales d\u2019utilisation disponibles sur l'application Burger King France et sur burgerking.fr",
#       "ending_at": "09/02/2023"
#     },
#     {
#       "id": "BW45BSOK",
#       "label": "1 Whopper offert pour votre anniversaire ",
#       "description": "Offre valable un mois hors service de livraison. Retrouvez la liste des restaurants participants et les conditions g\u00e9n\u00e9rales d\u2019utilisation du programme de fid\u00e9lit\u00e9 Kingdom sur l'application Burger King France et sur burgerking.fr. Pour connaitre le d\u00e9tail des produits offerts dans le cadre du Programme de fid\u00e9lit\u00e9 Kingdom, consultez les conditions g\u00e9n\u00e9rales d\u2019utilisation disponibles sur l'application Burger King France et sur burgerking.fr",
#       "ending_at": "09/02/2023"
#     }
#   ]
# }


def main(mail, password):
    try:
        driver = sd.get_driver()
        start = time.time()
        sd.login(driver, mail, password)
        while (token := sd.get_bearer_token(driver)) is None:
            time.sleep(1)
        kingdom = sd.get_kingdom(token, mail, password)
        profile = sd.get_profile(token, mail)
        print(json.dumps({
            "time_elapsed": round(time.time() - start, 2),
            "mail": mail,
            "birthdate": profile.birthdate,
            "hasKids": profile.kids,
            "points": kingdom.points,
            "coupons": [{
                "id": coupon.id,
                "label": coupon.label,
                "description": coupon.description,
                "ending_at": coupon.end_date
            } for coupon in kingdom.coupons]
        }))
    except Exception as e:
        # Print error in json format
        print(json.dumps({
            "error": str(e)
        }))
    finally:
        driver.close()
        driver.quit()


if __name__ == '__main__':
    main(sys.argv[1], sys.argv[2])

    # print(json.dumps({
    #             "time_elapsed": 10,
    #             "mail": "08rlub0uswx@1secmail.org",
    #             "birthdate": "12/03/1998",
    #             "hasKids": True,
    #             "points": 130,
    #             "coupons": [{
    #                 "id": "BPL9O8CS",
    #                 "label": "1 Whopper offert pour votre anniversaire ",
    #                 "description": "Offre valable un mois hors service de livraison. Retrouvez la liste des restaurants participants et les conditions g\u00e9n\u00e9rales d\u2019utilisation du programme de fid\u00e9lit\u00e9 Kingdom sur l'application Burger King France et sur burgerking.fr. Pour connaitre le d\u00e9tail des produits offerts dans le cadre du Programme de fid\u00e9lit\u00e9 Kingdom, consultez les conditions g\u00e9n\u00e9rales d\u2019utilisation disponibles sur l'application Burger King France et sur burgerking.fr",
    #                 "ending_at": "09/02/2023"
    #             }]
    #         }))
from coupon import Coupon

class Kingdom:

    def __init__(self, mail, password, data):
        self.mail = mail
        self.password = password
        self.qrcode = data['kingdomAuthCode']
        self.points = data['pointInfos']['points']
        self.coupons = [Coupon(self, coupon) for coupon in data['coupons']]

    def __str__(self):
        return "Kingdom: " + self.mail + " - " + self.qrcode + " - " + str(self.points) + " - " + str(self.coupons)

    def __repr__(self):
        return self.__str__()

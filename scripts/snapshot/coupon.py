class Coupon:

    def __init__(self, mail, data):
        self.mail = mail
        self.id = data['id']
        self.end_date = data['endDate']
        self.label = data['label']
        self.description = data['description']

    def __str__(self):
        return "Coupon: " + self.id + " - " + self.end_date + " - " + self.label + " - " + self.description
    
    def __repr__(self):
        return self.__str__()
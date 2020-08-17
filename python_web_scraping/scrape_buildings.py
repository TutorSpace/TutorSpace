import pandas
from bs4 import BeautifulSoup, NavigableString, Tag


def scrape_buildings():
    soup = BeautifulSoup(open("buildings.html", encoding='utf8'), 'html.parser')
    tag_list = soup.find('tbody')
    building_list = []
    for child in tag_list.contents:
        print(child)
        if isinstance(child, NavigableString):
            continue
        if isinstance(child, Tag) and child is not None and child.td is not None:
            building_list.append([child.th.string, child.td.string])

    return building_list


if __name__ == '__main__':
    url = "https://classes.usc.edu/building-directory/"
    res_list = scrape_buildings()
    df = pandas.DataFrame(res_list, columns=['code', 'name'])
    df.to_csv(r"buildings.csv")